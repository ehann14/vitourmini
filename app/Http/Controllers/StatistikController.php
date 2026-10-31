<?php

namespace App\Http\Controllers;

use App\Models\Panorama;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    /**
     * Halaman statistik pengunjung
     */
    public function index(Request $request)
    {
        $periode = (int) $request->input('periode', 7);

        if (! in_array($periode, [1, 7, 30, 90], true)) {
            $periode = 7;
        }

        $mulai = now()->subDays($periode - 1)->startOfDay();

        $cacheKey = 'statistik:'.$periode.':'.now()->toDateString();

        $stats = cache()->remember($cacheKey, 300, function () use ($mulai, $periode) {
            $hariIni = today();
            $besok = today()->addDay();
            $kemarin = today()->subDay();
            $awalPeriode = fn () => VisitorLog::publik()->where('visited_at', '>=', $mulai);

            $kunjunganHariIni = VisitorLog::publik()
                ->where('visited_at', '>=', $hariIni)
                ->where('visited_at', '<', $besok)
                ->count();
            $pengunjungHariIni = VisitorLog::publik()
                ->where('visited_at', '>=', $hariIni)
                ->where('visited_at', '<', $besok)
                ->distinct('visitor_id')
                ->count('visitor_id');
            $kunjunganKemarin = VisitorLog::publik()
                ->where('visited_at', '>=', $kemarin)
                ->where('visited_at', '<', $hariIni)
                ->count();

            $kunjunganPeriode = $awalPeriode()->count();
            $pengunjungPeriode = $awalPeriode()->distinct('visitor_id')->count('visitor_id');
            $totalKunjungan = VisitorLog::publik()->count();
            $totalPengunjung = VisitorLog::publik()->distinct('visitor_id')->count('visitor_id');

            $selisihHarian = $kunjunganKemarin > 0
                ? round((($kunjunganHariIni - $kunjunganKemarin) / $kunjunganKemarin) * 100)
                : ($kunjunganHariIni > 0 ? 100 : 0);

            $halamanPerPengunjung = $pengunjungPeriode > 0
                ? round($kunjunganPeriode / $pengunjungPeriode, 1)
                : 0;

            $harian = $awalPeriode()
                ->selectRaw('DATE(visited_at) as tanggal,
                             COUNT(*) as kunjungan,
                             COUNT(DISTINCT visitor_id) as pengunjung')
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get()
                ->keyBy('tanggal');

            $grafikLabel = [];
            $grafikKunjungan = [];
            $grafikPengunjung = [];

            for ($i = $periode - 1; $i >= 0; $i--) {
                $tgl = now()->subDays($i);
                $key = $tgl->toDateString();

                $grafikLabel[] = $tgl->translatedFormat($periode > 30 ? 'd/m' : 'd M');
                $grafikKunjungan[] = (int) ($harian->get($key)?->kunjungan ?? 0);
                $grafikPengunjung[] = (int) ($harian->get($key)?->pengunjung ?? 0);
            }

            $namaPanorama = Panorama::pluck('name', 'scene_id');

            $panoramaPopuler = $awalPeriode()
                ->where('page_type', 'panorama')
                ->whereNotNull('scene_id')
                ->selectRaw('scene_id,
                             COUNT(*) as kunjungan,
                             COUNT(DISTINCT visitor_id) as pengunjung')
                ->groupBy('scene_id')
                ->orderByDesc('kunjungan')
                ->take(10)
                ->get()
                ->map(function ($row) use ($namaPanorama) {
                    $row->nama = $namaPanorama[$row->scene_id] ?? $row->scene_id;

                    return $row;
                });

            $maxPanorama = (int) ($panoramaPopuler->max('kunjungan') ?: 1);

            $halamanPopuler = $awalPeriode()
                ->selectRaw('page_type, COUNT(*) as total')
                ->groupBy('page_type')
                ->orderByDesc('total')
                ->pluck('total', 'page_type');

            $perangkat = $awalPeriode()
                ->selectRaw('device_type, COUNT(*) as total')
                ->groupBy('device_type')
                ->orderByDesc('total')
                ->pluck('total', 'device_type');

            $browser = $awalPeriode()
                ->selectRaw('browser, COUNT(*) as total')
                ->groupBy('browser')
                ->orderByDesc('total')
                ->take(6)
                ->pluck('total', 'browser');

            $hourExpression = match (DB::connection()->getDriverName()) {
                'sqlite' => "CAST(strftime('%H', visited_at) AS INTEGER)",
                'pgsql' => 'EXTRACT(HOUR FROM visited_at)',
                'sqlsrv' => 'DATEPART(HOUR, visited_at)',
                default => 'HOUR(visited_at)',
            };

            $perJam = $awalPeriode()
                ->selectRaw("{$hourExpression} as jam, COUNT(*) as total")
                ->groupBy('jam')
                ->pluck('total', 'jam');

            $grafikJam = [];
            for ($j = 0; $j < 24; $j++) {
                $grafikJam[] = (int) $perJam->get($j, 0);
            }
            $jamTersibuk = $perJam->isNotEmpty() ? (int) $perJam->sortDesc()->keys()->first() : null;

            $asal = $awalPeriode()
                ->selectRaw('referrer, COUNT(*) as total')
                ->groupBy('referrer')
                ->orderByDesc('total')
                ->take(50)
                ->get()
                ->groupBy(function ($row) {
                    if (! $row->referrer) {
                        return 'Langsung / bookmark';
                    }

                    $host = parse_url($row->referrer, PHP_URL_HOST) ?: 'Lainnya';

                    return str_contains($host, parse_url(config('app.url'), PHP_URL_HOST) ?: '###')
                        ? 'Dari halaman sendiri'
                        : $host;
                })
                ->map(fn ($grup) => $grup->sum('total'))
                ->sortDesc()
                ->take(6);

            $kota = $awalPeriode()
                ->whereNotNull('city')
                ->selectRaw('city, COUNT(DISTINCT visitor_id) as total')
                ->groupBy('city')
                ->orderByDesc('total')
                ->take(8)
                ->pluck('total', 'city');

            return compact(
                'kunjunganHariIni',
                'pengunjungHariIni',
                'selisihHarian',
                'kunjunganPeriode',
                'pengunjungPeriode',
                'totalKunjungan',
                'totalPengunjung',
                'halamanPerPengunjung',
                'grafikLabel',
                'grafikKunjungan',
                'grafikPengunjung',
                'grafikJam',
                'jamTersibuk',
                'panoramaPopuler',
                'maxPanorama',
                'halamanPopuler',
                'perangkat',
                'browser',
                'asal',
                'kota'
            );
        });

        $kunjunganTerbaru = VisitorLog::publik()
            ->latest('visited_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.statistik', array_merge($stats, [
            'periode' => $periode,
            'kunjunganTerbaru' => $kunjunganTerbaru,
        ]));
    }

    /**
     * Hapus data kunjungan lama (untuk menjaga ukuran database)
     */
    public function bersihkan(Request $request)
    {
        $request->validate([
            'lebih_lama_dari' => 'required|integer|in:30,90,180,365,0',
        ]);

        $hari = (int) $request->input('lebih_lama_dari');

        $query = VisitorLog::query();

        if ($hari > 0) {
            $query->where('visited_at', '<', now()->subDays($hari));
            $pesan = "Data kunjungan lebih lama dari {$hari} hari berhasil dihapus.";
        } else {
            $pesan = 'Seluruh data kunjungan berhasil dihapus.';
        }

        $jumlah = $query->count();
        $query->delete();

        foreach ([1, 7, 30, 90] as $periode) {
            cache()->forget('statistik:'.$periode.':'.today()->toDateString());
        }

        return back()->with('success', "{$pesan} ({$jumlah} baris)");
    }

    /**
     * Ekspor CSV kunjungan
     */
    public function ekspor(Request $request)
    {
        $periode = (int) $request->input('periode', 7);
        $mulai = now()->subDays($periode - 1)->startOfDay();

        $namaFile = 'kunjungan-vitour-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($mulai) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Waktu', 'ID Pengunjung', 'IP', 'Perangkat', 'Browser', 'Platform', 'Halaman', 'Jenis', 'Kota', 'Asal']);

            VisitorLog::publik()
                ->where('visited_at', '>=', $mulai)
                ->orderBy('visited_at')
                ->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $r) {
                        fputcsv($out, [
                            Carbon::parse($r->visited_at)->format('Y-m-d H:i:s'),
                            substr($r->visitor_id, 0, 12),
                            $r->ip_address,
                            $r->device_type,
                            $r->browser,
                            $r->platform,
                            $r->path,
                            $r->page_type,
                            $r->city,
                            $r->referrer,
                        ]);
                    }
                });

            fclose($out);
        }, $namaFile, ['Content-Type' => 'text/csv']);
    }
}
