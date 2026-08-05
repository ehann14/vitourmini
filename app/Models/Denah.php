<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denah extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional, Laravel otomatis pakai 'denahs' dari nama class)
     */
    // protected $table = 'denahs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'gedung',
        'lantai',
        'position_x',
        'position_y',
        'panorama_id',
        'description',
        'icon',
        'order',
        'is_active',
        // ✅ Field informasi fasilitas ruangan
        'jumlah_kursi',
        'jumlah_meja',
        'jumlah_pc',
        'ukuran_ruangan',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'position_x'    => 'decimal:2',
        'position_y'    => 'decimal:2',
        'is_active'     => 'boolean',
        'jumlah_kursi'  => 'integer',
        'jumlah_meja'   => 'integer',
        'jumlah_pc'     => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * Default values untuk field tertentu
     */
    protected $attributes = [
        'is_active'     => true,
        'jumlah_kursi'  => 0,
        'jumlah_meja'   => 0,
        'jumlah_pc'     => 0,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Panorama (belongsTo)
     */
    public function panorama(): BelongsTo
    {
        return $this->belongsTo(Panorama::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope: hanya yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: hanya yang tidak aktif
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope: ordering default (urut berdasarkan order, lalu name)
     */
    public function scopeOrderByPosition($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * Scope: filter berdasarkan gedung
     */
    public function scopeByGedung($query, $gedung)
    {
        return $query->where('gedung', $gedung);
    }

    /**
     * Scope: filter berdasarkan lantai
     */
    public function scopeByLantai($query, $lantai)
    {
        return $query->where('lantai', $lantai);
    }

    /**
     * Scope: hanya yang punya panorama
     */
    public function scopeHasPanorama($query)
    {
        return $query->whereNotNull('panorama_id');
    }

    /**
     * Scope: hanya yang punya koordinat (position_x & y)
     */
    public function scopeHasPosition($query)
    {
        return $query->whereNotNull('position_x')
                     ->whereNotNull('position_y');
    }

    /**
     * Scope: cari berdasarkan nama (search)
     */
    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) return $query;
        
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('gedung', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (Getter otomatis)
    |--------------------------------------------------------------------------
    */

    /**
     * Accessor: deskripsi dengan fallback "Tidak ada deskripsi"
     * 
     * Pakai: $denah->description_display
     */
    public function getDescriptionDisplayAttribute(): string
    {
        return !empty($this->description) ? $this->description : 'Tidak ada deskripsi';
    }

    /**
     * Accessor: lokasi lengkap (gedung + lantai)
     * 
     * Pakai: $denah->location_full
     */
    public function getLocationFullAttribute(): string
    {
        $parts = [$this->gedung];
        if ($this->lantai) {
            $parts[] = 'Lantai ' . $this->lantai;
        }
        return implode(' - ', $parts);
    }

    /**
     * Accessor: total fasilitas (kursi + meja + pc)
     * 
     * Pakai: $denah->total_facilities
     */
    public function getTotalFacilitiesAttribute(): int
    {
        return ($this->jumlah_kursi ?? 0) + ($this->jumlah_meja ?? 0) + ($this->jumlah_pc ?? 0);
    }

    /**
     * Accessor: cek apakah punya panorama
     * 
     * Pakai: $denah->has_panorama
     */
    public function getHasPanoramaAttribute(): bool
    {
        return !is_null($this->panorama_id);
    }

    /**
     * Accessor: cek apakah punya koordinat valid
     * 
     * Pakai: $denah->has_valid_position
     */
    public function getHasValidPositionAttribute(): bool
    {
        return !is_null($this->position_x) && !is_null($this->position_y);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Konversi ke array untuk API response
     * Konsisten dengan format yang diharapkan frontend
     */
    public function toApiArray(): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'gedung'           => $this->gedung,
            'lantai'           => $this->lantai,
            'position_x'       => $this->position_x,
            'position_y'       => $this->position_y,
            'icon'             => $this->icon,
            'description'      => $this->description, // Kirim aslinya, frontend handle fallback
            'jumlah_kursi'     => (int) ($this->jumlah_kursi ?? 0),
            'jumlah_meja'      => (int) ($this->jumlah_meja ?? 0),
            'jumlah_pc'        => (int) ($this->jumlah_pc ?? 0),
            'ukuran_ruangan'   => $this->ukuran_ruangan,
            'has_panorama'     => $this->has_panorama,
            'panorama_id'      => $this->panorama?->scene_id,
            'panorama_name'    => $this->panorama?->name,
            'location_full'    => $this->location_full,
        ];
    }

    /**
     * Cek apakah ruangan ini punya fasilitas (meja/kursi/pc)
     */
    public function hasFacilities(): bool
    {
        return $this->total_facilities > 0;
    }

    /**
     * Cek apakah ruangan ini "laboratorium komputer"
     * (Logika sederhana: punya PC)
     */
    public function isComputerLab(): bool
    {
        return ($this->jumlah_pc ?? 0) > 0;
    }

    /**
     * Generate inisial untuk avatar
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->name));
        $initials = '';
        
        foreach (array_slice($words, 0, 2) as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        
        return $initials ?: '?';
    }
}