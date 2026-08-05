<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panorama;
use App\Models\Achievement;
use App\Models\Comment;

class HomeController extends Controller
{
    /**
     * Halaman utama /beranda
     * - Menampilkan panorama aktif
     * - Menampilkan maksimal 10 komentar terbaru yang sudah disetujui (FIFO)
     */
    public function index()
    {
        // ✅ Ambil panorama aktif yang akan ditampilkan
        $panoramas = Panorama::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
        
        // ✅ Ambil komentar yang sudah disetujui, maksimal 10 terbaru
        // Urutan: terbaru dulu (latest), ambil 10 pertama
        $comments = Comment::where('is_approved', true)
                           ->latest()
                           ->take(10)
                           ->get();
        
        return view('home', compact('panoramas', 'comments'));
    }

    /**
     * Halaman prestasi
     */
    public function prestasi()
    {
        $achievements = Achievement::where('is_active', true)
            ->orderBy('order')
            ->orderBy('date', 'desc')
            ->paginate(12);
        
        return view('prestasi', compact('achievements'));
    }

    /**
     * Halaman denah sekolah
     */
    public function denah()
    {
        $panoramas = Panorama::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get([
                'id', 
                'name', 
                'scene_id', 
                'type', 
                'icon', 
                'image_path', 
                'order',
                'hotspots'
            ]);
        
        return view('denah', compact('panoramas'));
    }

    /**
     * Viewer panorama berdasarkan scene_id
     */
    public function view(string $scene_id)
    {
        $panorama = Panorama::where('scene_id', $scene_id)
            ->where('is_active', true)
            ->firstOrFail();
        
        $allScenes = Panorama::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get(['id', 'name', 'scene_id', 'type', 'icon', 'image_path']);
        
        return view('viewer.index', compact('panorama', 'allScenes'));
    }

    /**
     * API Endpoint: Load data scene untuk navigasi AJAX
     */
    public function apiShow(string $scene_id)
    {
        try {
            $panorama = Panorama::where('scene_id', $scene_id)
                ->where('is_active', true)
                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $panorama->id,
                    'name' => $panorama->name,
                    'scene_id' => $panorama->scene_id,
                    'image_path' => asset($panorama->image_path),
                    'type' => $panorama->type,
                    'hotspots' => $panorama->hotspots,
                    'icon' => $panorama->icon,
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Scene tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('API Panorama Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }
}