<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Panorama;
use App\Models\Denah;
use App\Models\VisitorLog;
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

        // === Statistik Pengunjung (30 hari terakhir) ===
        $periode = 30;
        $mulai = now()->subDays($periode - 1)->startOfDay();

        $kunjunganHariIni = VisitorLog::publik()->whereDate('visited_at', today())->count();
        $pengunjungHariIni = VisitorLog::publik()->whereDate('visited_at', today())
            ->distinct('visitor_id')->count('visitor_id');
        $kunjunganKemarin = VisitorLog::publik()->whereDate('visited_at', today()->subDay())->count();

        $selisihHarian = $kunjunganKemarin > 0
            ? round((($kunjunganHariIni - $kunjunganKemarin) / $kunjunganKemarin) * 100)
            : ($kunjunganHariIni > 0 ? 100 : 0);

        $totalPengunjung = VisitorLog::publik()->distinct('visitor_id')->count('visitor_id');

        $harian = VisitorLog::publik()
            ->where('visited_at', '>=', $mulai)
            ->selectRaw('DATE(visited_at) as tanggal, COUNT(*) as kunjungan, COUNT(DISTINCT visitor_id) as pengunjung')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $grafikLabelHarian = [];
        $grafikRangeMulai = $mulai->translatedFormat('d M Y');
        $grafikRangeAkhir = now()->translatedFormat('d M Y');
        $grafikKunjunganHarian = [];
        $grafikPengunjungHarian = [];

        for ($i = $periode - 1; $i >= 0; $i--) {
            $tgl = now()->subDays($i);
            $key = $tgl->toDateString();

            $grafikLabelHarian[]      = $tgl->translatedFormat('d M');
            $grafikKunjunganHarian[]  = (int) ($harian->get($key)?->kunjungan ?? 0);
            $grafikPengunjungHarian[] = (int) ($harian->get($key)?->pengunjung ?? 0);
        }

        return view('admin.dashboard', compact(
            'totalPanoramas', 
            'activePanoramas', 
            'recentPanoramas',
            'totalDenahs',
            'recentDenahs',
            'denahByGedung',
            'kunjunganHariIni',
            'pengunjungHariIni',
            'selisihHarian',
            'totalPengunjung',
            'grafikLabelHarian',
            'grafikKunjunganHarian',
            'grafikPengunjungHarian',
            'grafikRangeMulai',
            'grafikRangeAkhir'
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