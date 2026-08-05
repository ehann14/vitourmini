<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Simpan komentar baru dari form publik
     * - Default: is_approved = false (menunggu persetujuan admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:500',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'message.required' => 'Pesan/komentar wajib diisi',
        ]);

        Comment::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'is_approved' => false, // Default: menunggu approval
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Komentar Anda menunggu persetujuan admin.');
    }
}