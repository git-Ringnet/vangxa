<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $user = Auth::user();
        
        $comment = new Comment([
            'post_id' => $request->post_id,
            'user_id' => $user->id ?? 1,
            'content' => $request->content
        ]);

        if ($request->parent_id) {
            $parent = Comment::find($request->parent_id);
            $parent->appendNode($comment);
        } else {
            $comment->save(); // comment gốc
        }

        // Lấy thông tin post để phát sự kiện
        $post = Post::find($request->post_id);
        
        // Phát sự kiện comment mới
        if ($post && $post->user_id != $user->id) {
            event(new CommentEvent($comment, $post, $user));
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Bạn không có quyền xóa bình luận này!');
        }

        $comment->delete();
        return back()->with('success', 'Bình luận đã được xóa thành công!');
    }
}
