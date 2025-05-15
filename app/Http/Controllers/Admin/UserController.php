<?php

namespace App\Http\Controllers\Admin;

use App\Events\TestReverbEvent;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
     * @param integer|null $viewerId ID của người xem, null nếu là khách
     * @param integer $vendorId ID của người bán được xem
     * @return void
     */
    private function recordProfileView($viewerId, $vendorId)
    {
        // Lấy địa chỉ IP và User Agent
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        
        // Xác định nền tảng nguồn truy cập - ưu tiên sử dụng tham số UTM
        $utmSource = request()->query('utm_source');
        $referer = request()->header('referer');

        // Ghi log để debug
        \Illuminate\Support\Facades\Log::info('Profile View UTM Source: ' . $utmSource);
        \Illuminate\Support\Facades\Log::info('Profile View Referer: ' . $referer);
        
        // Ưu tiên sử dụng UTM Source nếu có
        $referrerPlatform = null;
        if (!empty($utmSource)) {
            // Chuẩn hóa utm_source thành tên nền tảng
            $referrerPlatform = $this->normalizePlatformName($utmSource);
        } else {
            // Nếu không có utm_source, thử xác định từ referer
            $referrerPlatform = $this->determineReferrerPlatform($referer);
        }
        
        // Ghi log platform đã phát hiện
        \Illuminate\Support\Facades\Log::info('Detected Platform: ' . $referrerPlatform);
        
        // Kiểm tra xem đã có lượt xem gần đây trong session chưa
        // Tạo key phân biệt cả vendor và nền tảng để tránh bỏ qua các lượt xem từ nền tảng khác nhau
        $viewKey = 'viewed_profile_' . $vendorId . '_' . ($referrerPlatform ?: 'direct');
        if (session()->has($viewKey) && session($viewKey) > now()->subMinutes(2)->timestamp) {
            // Đã có lượt xem từ nền tảng này trong 2 phút trước đó, bỏ qua để tránh đếm nhiều lần
            \Illuminate\Support\Facades\Log::info('Skipping duplicate view from platform: ' . $referrerPlatform);
            return;
        }
        
        // Lưu lượt xem vào session với timestamp hiện tại
        session([$viewKey => now()->timestamp]);
        
        // Ghi vào bảng profile_views
        \App\Models\ProfileView::create([
            'user_id' => $viewerId,
            'vendor_id' => $vendorId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referrer_platform' => $referrerPlatform
        ]);
    }
    
    /**
     * Chuẩn hóa tên nền tảng từ utm_source
     */
    private function normalizePlatformName($source)
    {
        if (empty($source)) {
            return null;
        }
        
        $source = strtolower(trim($source));
        
        // Ánh xạ giá trị utm_source với các nền tảng
        $platformMapping = [
            'fb' => 'facebook',
            'facebook' => 'facebook',
            'insta' => 'instagram',
            'instagram' => 'instagram',
            'ig' => 'instagram',
            'twitter' => 'twitter',
            'tw' => 'twitter',
            'x' => 'twitter',
            'tiktok' => 'tiktok',
            'tt' => 'tiktok',
            'google' => 'google',
            'gg' => 'google',
            'youtube' => 'youtube',
            'yt' => 'youtube',
            'linkedin' => 'linkedin',
            'li' => 'linkedin',
            'pinterest' => 'pinterest',
            'pin' => 'pinterest',
            'zalo' => 'zalo',
            'zl' => 'zalo'
        ];
        
        return $platformMapping[$source] ?? 'khác';
    }

    /**
     * Xác định nền tảng nguồn truy cập từ URL referrer
     * 
     * @param string|null $referer URL nguồn truy cập
     * @return string|null Tên nền tảng hoặc null nếu không xác định được
     */
    private function determineReferrerPlatform($referer)
    {
        if (empty($referer)) {
            return null;
        }
        
        $referer = strtolower($referer);
        
        // Kiểm tra các nền tảng phổ biến - sử dụng cách tiếp cận linh hoạt hơn
        $platforms = [
            'facebook' => ['facebook.com', 'fb.com', 'fbcdn.net', 'm.facebook.com'],
            'instagram' => ['instagram.com', 'cdninstagram.com', 'instagr.am'],
            'twitter' => ['twitter.com', 'x.com', 't.co', 'twimg.com'],
            'tiktok' => ['tiktok.com', 'tiktokv.com', 'tiktokcdn.com', 'musical.ly'],
            'google' => ['google.com', 'google.', 'goo.gl', 'g.co', 'plus.google.com'],
        ];
        
        foreach ($platforms as $platform => $domains) {
            foreach ($domains as $domain) {
                if (strpos($referer, $domain) !== false) {
                    return $platform;
                }
            }
        }
        
        // Kiểm tra các nguồn khác
        if (strpos($referer, 'youtube.com') !== false || 
            strpos($referer, 'youtu.be') !== false) {
            return 'youtube';
        } elseif (strpos($referer, 'linkedin.com') !== false) {
            return 'linkedin';
        } elseif (strpos($referer, 'pinterest.com') !== false || 
                 strpos($referer, 'pin.it') !== false) {
            return 'pinterest';
        } elseif (strpos($referer, 'zalo.me') !== false || 
                 strpos($referer, 'zalo.vn') !== false) {
            return 'zalo';
        }
        
        // Nếu không phải các nền tảng đã biết
        return 'khác';
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
