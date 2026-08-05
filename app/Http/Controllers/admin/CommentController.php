<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function toggleStatus($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = !$comment->is_approved;
        $comment->save();

        $status = $comment->is_approved ? 'disetujui' : 'ditolak';
        return back()->with('success', "Komentar berhasil {$status}.");
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}