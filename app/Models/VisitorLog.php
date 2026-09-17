<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $table = 'visitor_logs';

    protected $fillable = [
        'visitor_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'url',
        'path',
        'route_name',
        'page_type',
        'scene_id',
        'referrer',
        'country',
        'city',
        'is_admin',
        'visited_at',
    ];

    protected $casts = [
        'is_admin'   => 'boolean',
        'visited_at' => 'datetime',
    ];

    /** Hanya kunjungan pengunjung biasa (bukan admin) */
    public function scopePublik(Builder $q): Builder
    {
        return $q->where('is_admin', false);
    }

    /** Kunjungan dalam N hari terakhir */
    public function scopeDalamHari(Builder $q, int $hari): Builder
    {
        return $q->where('visited_at', '>=', now()->subDays($hari - 1)->startOfDay());
    }

    /** IP disamarkan sebagian, supaya lebih ramah privasi saat ditampilkan */
    public function getIpSamarAttribute(): string
    {
        $ip = (string) $this->ip_address;

        if ($ip === '') {
            return '-';
        }

        if (str_contains($ip, ':')) { // IPv6
            $parts = explode(':', $ip);
            return implode(':', array_slice($parts, 0, 3)) . ':****';
        }

        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            return "{$parts[0]}.{$parts[1]}.{$parts[2]}.*";
        }

        return $ip;
    }

    public function getIconPerangkatAttribute(): string
    {
        return match ($this->device_type) {
            'mobile'  => 'fa-mobile-screen',
            'tablet'  => 'fa-tablet-screen-button',
            'bot'     => 'fa-robot',
            default   => 'fa-desktop',
        };
    }
}
