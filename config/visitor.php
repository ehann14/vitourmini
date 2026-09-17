<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Aktifkan pencatatan pengunjung
    |--------------------------------------------------------------------------
    */
    'enabled' => env('VISITOR_TRACKING', true),

    /*
    |--------------------------------------------------------------------------
    | Catat juga kunjungan admin yang sedang login?
    | Tetap disimpan tapi ditandai is_admin = true, dan tidak dihitung
    | di statistik publik.
    |--------------------------------------------------------------------------
    */
    'track_admin' => env('VISITOR_TRACK_ADMIN', true),

    /*
    |--------------------------------------------------------------------------
    | Jeda anti-dobel (detik)
    | Kunjungan ke halaman yang sama oleh pengunjung yang sama dalam rentang
    | waktu ini tidak dicatat ulang (mencegah spam saat refresh).
    |--------------------------------------------------------------------------
    */
    'throttle_seconds' => 30,

    /*
    |--------------------------------------------------------------------------
    | Lokasi perkiraan dari IP (ip-api.com, gratis, tanpa API key)
    | Matikan kalau server tidak punya akses internet keluar.
    |--------------------------------------------------------------------------
    */
    'geo_enabled' => env('VISITOR_GEO', false),

    /*
    |--------------------------------------------------------------------------
    | Path yang tidak perlu dicatat
    |--------------------------------------------------------------------------
    */
    'ignore_paths' => [
        'admin/*',
        'api/*',
        'up',
        'build/*',
        'storage/*',
        'favicon.ico',
        'robots.txt',
    ],

];
