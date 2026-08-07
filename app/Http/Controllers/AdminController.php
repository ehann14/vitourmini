<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Panorama;
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
        // === Panorama Stats ===
        $totalPanoramas = Panorama::count();
        $activePanoramas = Panorama::where('is_active', true)->count();
        $recentPanoramas = Panorama::latest()->take(5)->get();

        // === Denah Stats ===
        $totalDenahs = Denah::count();
        
        // ✅ Ambil denah (titik pin) terbaru yang memiliki koordinat valid
        // dengan relasi panorama untuk preview gambar
        $recentDenahs = Denah::with('panorama')
            ->hasPosition() // hanya yang punya position_x & y
            ->latest()
            ->take(6)
            ->get();

        // === Group denah by gedung untuk statistik tambahan ===
        $denahByGedung = Denah::selectRaw('gedung, count(*) as total')
            ->whereNotNull('gedung')
            ->groupBy('gedung')
            ->pluck('total', 'gedung');

        return view('admin.dashboard', compact(
            'totalPanoramas', 
            'activePanoramas', 
            'recentPanoramas',
            'totalDenahs',
            'recentDenahs',
            'denahByGedung'
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