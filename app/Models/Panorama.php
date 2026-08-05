<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panorama extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi Laravel)
    protected $table = 'panoramas';

    // Kolom yang BOLEH diisi mass-assignment
    protected $fillable = [
        'name',
        'scene_id',
        'image_path',
        'type',
        'order',
        'is_active',
        'hotspots',
        'icon',
    ];

    // Kolom yang harus di-cast ke tipe data tertentu
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'hotspots' => 'array', // ← PENTING: Otomatis decode JSON string ke array PHP
    ];
}