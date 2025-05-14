<?php

namespace App\Http\Controllers\Admin;

use App\Events\TestReverbEvent;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Gán vai trò cho người dùng
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Tạo người dùng thành công.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Cập nhật vai trò
        $user->syncRoles($request->role);

        if ($request->password) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function updateInfo(Request $request)
    {

        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'referral_source' => 'nullable|string|max:255',
            'experience_expectation' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'referral_source' => $request->referral_source,
            'experience_expectation' => $request->experience_expectation,
        ]);

        return response()->json(['success' => true, 'message' => 'Cám ơn bạn đã cập nhật thông tin.']);
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xóa avatar cũ nếu có
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }

        // Tạo tên file duy nhất
        $avatar = $request->file('avatar');
        $filename = time() . '_' . $avatar->getClientOriginalName();

        // Đảm bảo thư mục tồn tại
        $destinationPath = public_path('image/avatars');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Lưu file vào thư mục public/image/avatars
        $avatar->move($destinationPath, $filename);

        // Cập nhật avatar path
        $avatarPath = 'image/avatars/' . $filename;

        $user->update([
            'avatar' => $avatarPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Avatar đã được cập nhật thành công',
            'avatar' => $user->avatar,
        ]);
    }

    public function show(Request $request)
    {
        $id_user = Auth::user()->id;
        $user = User::with('posts', 'trustlists', 'reviews')->find($id_user);
        $isOwnProfile = true; // Luôn là true vì đây là profile của người dùng hiện tại

        // Đếm số người theo dõi và đang theo dõi
        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        return view('users.profile', compact('user', 'isOwnProfile', 'followersCount', 'followingCount'));
    }

    /**
     * Hiển thị profile của người dùng khác bằng ID
     */
    public function showUserProfile($id)
    {
        $user = User::with('posts', 'trustlists', 'reviews')->findOrFail($id);
        $isOwnProfile = false;
        $isFollowing = false;

        // Kiểm tra xem người đang xem có phải chủ profile không
        if (Auth::check()) {
            $currentUser = Auth::user();
            if ($currentUser->id == $user->id) {
                $isOwnProfile = true;
            } else {
                // Kiểm tra xem người dùng hiện tại có đang theo dõi người này không
                $isFollowing = $currentUser->following()->where('following_id', $user->id)->exists();

                // Ghi lại lượt xem profile nếu không phải chủ profile
                $this->recordProfileView($currentUser->id, $user->id);
            }
        } else {
            // Ghi lại lượt xem cho khách (không đăng nhập)
            $this->recordProfileView(null, $user->id);
        }

        // Đếm số người theo dõi và đang theo dõi
        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        return view('users.profile', compact('user', 'isOwnProfile', 'isFollowing', 'followersCount', 'followingCount'));
    }

    /**
     * Ghi lại lượt xem profile của người bán
     * 
     * @param int|null $viewerId ID người xem (null nếu là khách)
     * @param int $vendorId ID người bán được xem
     * @return void
     */
    private function recordProfileView($viewerId, $vendorId)
    {
        // Phân loại vai trò của người dùng được xem
        $vendor = User::find($vendorId);

        // Chỉ ghi lại nếu người được xem là vendor/business hoặc đã tạo ít nhất 1 bài viết
        $isVendor = $vendor->hasRole('vendor') || $vendor->hasRole('business');
        $hasPosts = $vendor->posts()->exists();

        if ($isVendor || $hasPosts) {
            // Tạo bản ghi mới
            \App\Models\ProfileView::create([
                'user_id' => $viewerId,
                'vendor_id' => $vendorId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        }
    }

    /**
     * API endpoint để tìm kiếm người dùng
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Tìm kiếm người dùng theo tên hoặc email
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'email', 'avatar']);

        return response()->json($users);
    }
}
