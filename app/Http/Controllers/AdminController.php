<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Panorama;
use App\Models\Comment;
use App\Models\Denah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
    {
        // ✅ FIFO AUTO-DELETE: Pastikan maksimal 10 komentar approved di database
        $approvedCount = Comment::where('is_approved', true)->count();
        
        if ($approvedCount > 10) {
            $toDelete = $approvedCount - 10;
            Comment::where('is_approved', true)
                ->oldest()
                ->limit($toDelete)
                ->delete();
        }

        // === Panorama Stats ===
        $totalPanoramas = Panorama::count();
        $activePanoramas = Panorama::where('is_active', true)->count();
        $recentPanoramas = Panorama::latest()->take(5)->get();

        // === Denah Stats ===
        $totalDenahs = Denah::count();

        // === Comment Stats ===
        $totalComments = Comment::count();
        $pendingCommentsCount = Comment::where('is_approved', false)->count();
        $pendingComments = Comment::where('is_approved', false)
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalPanoramas', 
            'activePanoramas', 
            'recentPanoramas',
            'totalDenahs',
            'totalComments',
            'pendingCommentsCount',
            'pendingComments'
        ));
    }

    /**
     * Admin Logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Berhasil logout!');
    }
}