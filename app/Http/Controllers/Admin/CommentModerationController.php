<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentModerationController extends Controller
{
    public function index()
    {
        $comments = Comment::where('approved', false)->with('article')->latest()->get();
        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['approved' => true]);
        return back()->with('success', 'Комментарий одобрен!');
    }

    public function reject(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Комментарий отклонён!');
    }
}
