<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('owner')
            ->withCount('members')
            ->withCount('posts')
            ->get();
        $perPage = 5;
        $posts = Post::with(['user', 'group', 'likes', 'comments'])
            ->where('type', 3)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        $userGroups = Group::all();
        return view('pages.community.groups.index', compact('groups', 'posts', 'userGroups'));
    }

    public function create()
    {
        return view('pages.community.groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_private' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
            'avatar' => 'nullable|image|max:1024'
        ]);

        $group = new Group($validated);
        $group->user_id = Auth::id();

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Lưu vào thư mục public/groups/covers
            $destinationPath = public_path('groups/covers');
            $image->move($destinationPath, $filename);

            $group->cover_image = 'groups/covers/' . $filename; // lưu path vào DB
        }

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = time() . '_' . $image->getClientOriginalName();

            $destinationPath = public_path('groups/avatars');
            $image->move($destinationPath, $filename);

            $group->avatar = 'groups/avatars/' . $filename;
        }

        $group->save();

        // Add creator as admin
        $group->members()->attach(Auth::id(), ['role' => 'admin']);
        $group->increment('member_count');

        return redirect()->route('groupss.show', $group)
            ->with('success', 'Tạo nhóm thành công!');
    }

    public function show(String $id)
    {
        $group = Group::findOrFail($id);
        $group->load(['owner', 'members', 'posts' => function ($query) {
            $query->with('user')->latest()->paginate(10);
        }]);

        $users = User::all();
        $posts = Post::with(['user', 'group', 'likes', 'comments'])
            ->where('type', 3)
            ->where('group_id', $group->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.community.groups.show', compact('group', 'users', 'posts'));
    }

    public function edit(String $id)
    {
        $group = Group::findOrFail($id);
        return view('pages.community.groups.edit', compact('group'));
    }

    public function update(Request $request, String $id)
    {
        $group = Group::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
            'avatar' => 'nullable|image|max:1024'
        ]);

        // Xử lý ảnh cover
        if ($request->hasFile('cover_image')) {
            if ($group->cover_image && File::exists(public_path($group->cover_image))) {
                File::delete(public_path($group->cover_image));
            }

            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('groups/covers'), $filename);
            $validated['cover_image'] = 'groups/covers/' . $filename;
        }

        // Xử lý ảnh avatar
        if ($request->hasFile('avatar')) {
            if ($group->avatar && File::exists(public_path($group->avatar))) {
                File::delete(public_path($group->avatar));
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('groups/avatars'), $filename);
            $validated['avatar'] = 'groups/avatars/' . $filename;
        }

        $group->update($validated);

        return redirect()->route('groupss.show', $group)
            ->with('success', 'Cập nhật thông tin nhóm thành công');
    }

    public function destroy(String $id)
    {
        $group = Group::findOrFail($id);

        // Xóa ảnh cover nếu có
        if ($group->cover_image && File::exists(public_path($group->cover_image))) {
            File::delete(public_path($group->cover_image));
        }

        // Xóa ảnh avatar nếu có
        if ($group->avatar && File::exists(public_path($group->avatar))) {
            File::delete(public_path($group->avatar));
        }

        // Xoá các bài viết liên quan đến nhóm
        $group->posts()->each(function ($post) {
            $post->delete();
        });

        // Xoá thành viên
        $group->members()->detach();

        // Xóa group
        $group->delete();

        return redirect()->route('groupss.index')
            ->with('success', 'Xóa nhóm thành công');
    }

    public function join(String $id)
    {
        $group = Group::findOrFail($id);
        if (!$group->isMember(Auth::user())) {
            $group->members()->attach(Auth::id(), ['role' => 'member']);
            $group->increment('member_count');
            return back()->with('success', 'You have joined the group.');
        }
        return back()->with('error', 'You are already a member of this group.');
    }

    public function leave(String $id)
    {
        $group = Group::findOrFail($id);
        if ($group->isMember(Auth::user())) {
            if ($group->isAdmin(Auth::user()) && $group->members()->count() > 1) {
                return back()->with('error', 'Please assign another admin before leaving.');
            }
            $group->members()->detach(Auth::id());
            $group->decrement('member_count');
            return back()->with('success', 'You have left the group.');
        }
        return back()->with('error', 'You are not a member of this group.');
    }

    public function members(String $id)
    {
        $group = Group::findOrFail($id);
        $members = $group->members()
            ->withPivot('role', 'joined_at')
            ->paginate(20);

        return view('pages.community.groups.members', compact('group', 'members'));
    }

    public function updateMemberRole(Request $request, Group $group, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:member,moderator,admin'
        ]);

        $group->members()->updateExistingPivot($user->id, ['role' => $validated['role']]);

        return back()->with('success', 'Member role updated successfully.');
    }

    public function removeMember(Group $group, User $user)
    {
        if ($user->id === $group->user_id) {
            return back()->with('error', 'Cannot remove the group owner.');
        }

        $group->members()->detach($user->id);
        $group->decrement('member_count');

        return back()->with('success', 'Member removed successfully.');
    }

    public function addMember(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        // Check if user is already a member
        if ($group->members()->where('user_id', $request->user_id)->exists()) {
            return back()->with('error', 'User is already a member of this group.');
        }

        // Add user as member
        $group->members()->attach($request->user_id, [
            'role' => 'member',
            'joined_at' => now()
        ]);

        // Increment member count
        $group->increment('member_count');

        return back()->with('success', 'Member added successfully.');
    }
}
