<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            if ($this->layakDicatat($request, $response)) {
                $this->catat($request);
            }
        } catch (\Throwable $e) {
            // Statistik tidak boleh sampai membuat website error
            Log::warning('Gagal mencatat kunjungan: ' . $e->getMessage());
        }

        return $response;
    }

    private function layakDicatat(Request $request, Response $response): bool
    {
        if (! config('visitor.enabled', true)) {
            return false;
        }

        // Hanya halaman biasa yang dibuka langsung
        if (! $request->isMethod('GET') || $request->ajax() || $request->wantsJson()) {
            return false;
        }

        // Hanya response HTML yang sukses
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type');
        if ($contentType !== '' && ! str_contains($contentType, 'text/html')) {
            return false;
        }

        $abaikan = (array) config('visitor.ignore_paths', []);
        if ($abaikan !== [] && $request->is(...$abaikan)) {
            return false;
        }

        if (Auth::check() && ! config('visitor.track_admin', true)) {
            return false;
        }

        // Anti-dobel saat refresh
        $kunci = 'visit:' . $this->visitorId($request) . ':' . md5($request->path());
        if (Cache::has($kunci)) {
            return false;
        }
        Cache::put($kunci, 1, (int) config('visitor.throttle_seconds', 30));

        return true;
    }

    private function catat(Request $request): void
    {
        $ua       = (string) $request->userAgent();
        $perangkat = $this->deteksiPerangkat($ua);
        $halaman   = $this->jenisHalaman($request);
        $lokasi    = $this->lokasiDariIp($request->ip());

        VisitorLog::create([
            'visitor_id'  => $this->visitorId($request),
            'ip_address'  => $request->ip(),
            'user_agent'  => mb_substr($ua, 0, 1000),
            'device_type' => $perangkat['device'],
            'browser'     => $perangkat['browser'],
            'platform'    => $perangkat['platform'],
            'url'         => mb_substr($request->fullUrl(), 0, 500),
            'path'        => mb_substr('/' . ltrim($request->path(), '/'), 0, 255),
            'route_name'  => $request->route()?->getName(),
            'page_type'   => $halaman['type'],
            'scene_id'    => $halaman['scene_id'],
            'referrer'    => mb_substr((string) $request->headers->get('referer'), 0, 500) ?: null,
            'country'     => $lokasi['country'],
            'city'        => $lokasi['city'],
            'is_admin'    => Auth::check(),
            'visited_at'  => now(),
        ]);
    }

    /**
     * ID pengunjung anonim: hash dari session id.
     * Tidak bisa dipakai untuk mengidentifikasi orangnya,
     * hanya untuk membedakan satu kunjungan dengan kunjungan lain.
     */
    private function visitorId(Request $request): string
    {
        $dasar = $request->hasSession()
            ? $request->session()->getId()
            : $request->ip() . '|' . $request->userAgent();

        return hash('sha256', $dasar . config('app.key'));
    }

    private function jenisHalaman(Request $request): array
    {
        $route = $request->route()?->getName();

        return match (true) {
            $route === 'view'   => ['type' => 'panorama', 'scene_id' => $request->route('scene_id')],
            $route === 'denah'  => ['type' => 'denah',    'scene_id' => null],
            $route === 'home'   => ['type' => 'home',     'scene_id' => null],
            $route === 'splash' => ['type' => 'splash',   'scene_id' => null],
            default             => ['type' => 'lainnya',  'scene_id' => null],
        };
    }

    private function deteksiPerangkat(string $ua): array
    {
        $uaLower = strtolower($ua);

        $bot = (bool) preg_match('/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|preview|monitor|curl|wget/i', $ua);

        $device = match (true) {
            $bot => 'bot',
            (bool) preg_match('/ipad|tablet|playbook|silk|(android(?!.*mobile))/i', $ua) => 'tablet',
            (bool) preg_match('/mobile|iphone|ipod|android.*mobile|windows phone|blackberry/i', $ua) => 'mobile',
            default => 'desktop',
        };

        $browser = match (true) {
            $bot => 'Bot / Crawler',
            str_contains($uaLower, 'edg/')                              => 'Edge',
            str_contains($uaLower, 'opr/') || str_contains($uaLower, 'opera') => 'Opera',
            str_contains($uaLower, 'samsungbrowser')                    => 'Samsung Internet',
            str_contains($uaLower, 'firefox')                           => 'Firefox',
            str_contains($uaLower, 'chrome')                            => 'Chrome',
            str_contains($uaLower, 'safari')                            => 'Safari',
            default                                                     => 'Lainnya',
        };

        $platform = match (true) {
            str_contains($uaLower, 'android')                                     => 'Android',
            (bool) preg_match('/iphone|ipad|ipod/i', $ua)                         => 'iOS',
            str_contains($uaLower, 'windows')                                     => 'Windows',
            str_contains($uaLower, 'mac os')                                      => 'macOS',
            str_contains($uaLower, 'linux')                                       => 'Linux',
            default                                                               => 'Lainnya',
        };

        return compact('device', 'browser', 'platform');
    }

    /**
     * Perkiraan lokasi dari IP. Hasil di-cache 24 jam per IP.
     */
    private function lokasiDariIp(?string $ip): array
    {
        $kosong = ['country' => null, 'city' => null];

        if (! config('visitor.geo_enabled', false) || ! $ip) {
            return $kosong;
        }

        // IP lokal / private tidak punya lokasi
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return ['country' => 'Lokal', 'city' => 'Jaringan lokal'];
        }

        return Cache::remember('geo:' . $ip, now()->addDay(), function () use ($ip, $kosong) {
            try {
                $json = @file_get_contents(
                    "http://ip-api.com/json/{$ip}?fields=status,country,city",
                    false,
                    stream_context_create(['http' => ['timeout' => 2]])
                );

                $data = json_decode((string) $json, true);

                if (($data['status'] ?? '') === 'success') {
                    return [
                        'country' => $data['country'] ?? null,
                        'city'    => $data['city'] ?? null,
                    ];
                }
            } catch (\Throwable) {
                // abaikan, lokasi opsional
            }

            return $kosong;
        });
    }
}
