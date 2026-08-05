<?php

namespace App\Http\Controllers;

use App\Models\Denah;
use App\Models\Panorama;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DenahController extends Controller
{
    /**
     * Display the denah page with virtual tour
     */
    public function show()
    {
        $denahs = Denah::with('panorama')
            ->active()
            ->orderByPosition()
            ->get();
        
        $panoramas = Panorama::where('is_active', true)->get();
        
        $comments = Comment::where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('denah', compact('denahs', 'panoramas', 'comments'));
    }

    /**
     * ✅ API: Get denah data as JSON
     * FIX: Kirim scene_id dan panorama_id secara terpisah agar tidak ambigu
     */
    public function getData()
    {
        $denahs = Denah::with('panorama')
            ->active()
            ->orderByPosition()
            ->get()
            ->map(function($denah) {
                // ✅ FIX: Pisahkan antara panorama primary key dan scene_id
                return [
                    'id'               => $denah->id,
                    'name'             => $denah->name,
                    'gedung'           => $denah->gedung,
                    'lantai'           => $denah->lantai,
                    'position_x'       => $denah->position_x,
                    'position_y'       => $denah->position_y,
                    'icon'             => $denah->icon,
                    
                    // ✅ Kirim description apa adanya
                    'description'      => $denah->description,
                    
                    'jumlah_kursi'     => (int) ($denah->jumlah_kursi ?? 0),
                    'jumlah_meja'      => (int) ($denah->jumlah_meja ?? 0),
                    'jumlah_pc'        => (int) ($denah->jumlah_pc ?? 0),
                    'ukuran_ruangan'   => $denah->ukuran_ruangan,
                    
                    // ✅ FIX: Pisahkan antara ID database dan scene_id
                    'has_panorama'     => !is_null($denah->panorama) && !is_null($denah->panorama->scene_id),
                    'panorama_id'      => $denah->panorama_id,              // Primary key (integer)
                    'scene_id'         => $denah->panorama?->scene_id,      // Scene identifier (string) - untuk Pannellum
                    'panorama_name'    => $denah->panorama?->name,
                ];
            });

        // ✅ Log untuk debugging
        Log::info('Denah API response', [
            'count' => $denahs->count(),
            'sample' => $denahs->first()
        ]);

        return response()->json([
            'success' => true,
            'data'    => $denahs
        ]);
    }

    /**
     * ✅ DEBUG: Lihat detail satu denah (untuk cek isi database langsung)
     * Akses: GET /api/denah-detail/{id}
     */
    public function showDetail($id)
    {
        $denah = Denah::with('panorama')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data'    => [
                'id'               => $denah->id,
                'name'             => $denah->name,
                'description'      => $denah->description,
                'panorama_id'      => $denah->panorama_id,
                'panorama'         => $denah->panorama ? [
                    'id'       => $denah->panorama->id,
                    'scene_id' => $denah->panorama->scene_id,
                    'name'     => $denah->panorama->name,
                ] : null,
            ],
            '_debug'  => [
                'fillable_fields' => (new Denah)->getFillable(),
                'has_description_in_fillable' => in_array('description', (new Denah)->getFillable()),
                'has_panorama_id_in_fillable' => in_array('panorama_id', (new Denah)->getFillable()),
            ]
        ]);
    }

    /**
     * ✅ DEBUG: Cek integritas data denah dan panorama
     * Akses: GET /api/denah-check-integrity
     */
    public function checkIntegrity()
    {
        $denahs = Denah::with('panorama')->get();
        
        $issues = [];
        $validCount = 0;
        
        foreach ($denahs as $denah) {
            $issue = null;
            
            // Cek 1: Apakah panorama_id merujuk ke panorama yang exist?
            if ($denah->panorama_id && !$denah->panorama) {
                $issue = "panorama_id {$denah->panorama_id} tidak ada di tabel panoramas (orphan reference)";
            }
            
            // Cek 2: Apakah panorama punya scene_id?
            if ($denah->panorama && !$denah->panorama->scene_id) {
                $issue = "Panorama id {$denah->panorama->id} tidak punya scene_id";
            }
            
            // Cek 3: Apakah ada scene_id duplikat?
            if ($denah->panorama && $denah->panorama->scene_id) {
                $duplicateCount = Panorama::where('scene_id', $denah->panorama->scene_id)
                    ->where('id', '!=', $denah->panorama->id)
                    ->count();
                if ($duplicateCount > 0) {
                    $issue = "scene_id '{$denah->panorama->scene_id}' duplikat di {$duplicateCount} panorama lain";
                }
            }
            
            if ($issue) {
                $issues[] = [
                    'denah_id'   => $denah->id,
                    'denah_name' => $denah->name,
                    'issue'      => $issue
                ];
            } else {
                $validCount++;
            }
        }
        
        return response()->json([
            'success'     => true,
            'total'       => $denahs->count(),
            'valid'       => $validCount,
            'issues'      => $issues,
            'issue_count' => count($issues)
        ]);
    }

    /**
     * Display admin denah management page
     */
    public function index()
    {
        $denahs = Denah::with('panorama')
            ->orderBy('gedung')
            ->orderBy('order')
            ->get();
        
        return view('admin.denah.index', compact('denahs'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $panoramas = Panorama::where('is_active', true)->get();
        $gedungList = $this->getGedungList();
        
        return view('admin.denah.create', compact('panoramas', 'gedungList'));
    }

    /**
     * ✅ Store new denah (dengan explicit assignment untuk antisipasi fillable)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'gedung'          => 'required|string|max:50',
            'lantai'          => 'nullable|string|max:20',
            'position_x'      => 'required|numeric|min:0|max:100',
            'position_y'      => 'required|numeric|min:0|max:100',
            'panorama_id'     => 'nullable|exists:panoramas,id',
            'description'     => 'nullable|string|max:1000',
            'icon'            => 'nullable|string|max:50',
            'order'           => 'nullable|integer',
            'jumlah_kursi'    => 'nullable|integer|min:0',
            'jumlah_meja'     => 'nullable|integer|min:0',
            'jumlah_pc'       => 'nullable|integer|min:0',
            'ukuran_ruangan'  => 'nullable|string|max:100',
            'is_active'       => 'sometimes|boolean',
        ]);

        // ✅ Normalisasi is_active
        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1';

        // ✅ Normalisasi integer fields
        $validated['jumlah_kursi'] = $validated['jumlah_kursi'] ?? 0;
        $validated['jumlah_meja']  = $validated['jumlah_meja'] ?? 0;
        $validated['jumlah_pc']    = $validated['jumlah_pc'] ?? 0;

        // ✅ PENTING: Gunakan explicit assignment untuk field kritis
        // Ini bypass masalah $fillable di model (saat kamu lupa update fillable)
        $denah = new Denah();
        $denah->name            = $validated['name'];
        $denah->gedung          = $validated['gedung'];
        $denah->lantai          = $validated['lantai'] ?? null;
        $denah->position_x      = $validated['position_x'];
        $denah->position_y      = $validated['position_y'];
        $denah->panorama_id     = $validated['panorama_id'] ?? null;
        $denah->description     = $validated['description'] ?? null; // ✅ Explicit!
        $denah->icon            = $validated['icon'] ?? null;
        $denah->order           = $validated['order'] ?? null;
        $denah->jumlah_kursi    = $validated['jumlah_kursi'];
        $denah->jumlah_meja     = $validated['jumlah_meja'];
        $denah->jumlah_pc       = $validated['jumlah_pc'];
        $denah->ukuran_ruangan  = $validated['ukuran_ruangan'] ?? null;
        $denah->is_active       = $validated['is_active'];
        $denah->save();

        // ✅ Log untuk debugging
        Log::info('Denah created', [
            'id'          => $denah->id,
            'name'        => $denah->name,
            'description' => $denah->description,
            'panorama_id' => $denah->panorama_id
        ]);

        return redirect()->route('admin.denah.index')
            ->with('success', "Titik denah '{$denah->name}' berhasil ditambahkan!");
    }

    /**
     * Show edit form
     */
    public function edit(Denah $denah)
    {
        $panoramas = Panorama::where('is_active', true)->get();
        $gedungList = $this->getGedungList();
        
        return view('admin.denah.edit', compact('denah', 'panoramas', 'gedungList'));
    }

    /**
     * ✅ Update denah (dengan explicit assignment)
     */
    public function update(Request $request, Denah $denah)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'gedung'          => 'required|string|max:50',
            'lantai'          => 'nullable|string|max:20',
            'position_x'      => 'required|numeric|min:0|max:100',
            'position_y'      => 'required|numeric|min:0|max:100',
            'panorama_id'     => 'nullable|exists:panoramas,id',
            'description'     => 'nullable|string|max:1000',
            'icon'            => 'nullable|string|max:50',
            'order'           => 'nullable|integer',
            'jumlah_kursi'    => 'nullable|integer|min:0',
            'jumlah_meja'     => 'nullable|integer|min:0',
            'jumlah_pc'       => 'nullable|integer|min:0',
            'ukuran_ruangan'  => 'nullable|string|max:100',
            'is_active'       => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1';
        $validated['jumlah_kursi'] = $validated['jumlah_kursi'] ?? 0;
        $validated['jumlah_meja']  = $validated['jumlah_meja'] ?? 0;
        $validated['jumlah_pc']    = $validated['jumlah_pc'] ?? 0;

        // ✅ PENTING: Explicit assignment - antisipasi kalau $fillable belum update
        $denah->name            = $validated['name'];
        $denah->gedung          = $validated['gedung'];
        $denah->lantai          = $validated['lantai'] ?? null;
        $denah->position_x      = $validated['position_x'];
        $denah->position_y      = $validated['position_y'];
        $denah->panorama_id     = $validated['panorama_id'] ?? null;
        $denah->description     = $validated['description'] ?? null; // ✅ Explicit!
        $denah->icon            = $validated['icon'] ?? null;
        $denah->order           = $validated['order'] ?? null;
        $denah->jumlah_kursi    = $validated['jumlah_kursi'];
        $denah->jumlah_meja     = $validated['jumlah_meja'];
        $denah->jumlah_pc       = $validated['jumlah_pc'];
        $denah->ukuran_ruangan  = $validated['ukuran_ruangan'] ?? null;
        $denah->is_active       = $validated['is_active'];
        $denah->save();

        Log::info('Denah updated', [
            'id'          => $denah->id,
            'name'        => $denah->name,
            'description' => $denah->description,
            'panorama_id' => $denah->panorama_id
        ]);

        return redirect()->route('admin.denah.index')
            ->with('success', "Titik denah '{$denah->name}' berhasil diperbarui!");
    }

    /**
     * ✅ AJAX: Update description saja (untuk quick fix data yang sudah ada)
     * Route: POST /admin/denah/{denah}/update-description
     */
    public function updateDescription(Request $request, Denah $denah)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:1000',
        ]);

        // Explicit assignment bypass fillable
        $denah->description = $validated['description'] ?? null;
        $denah->save();

        return response()->json([
            'success' => true,
            'message' => 'Deskripsi berhasil diupdate',
            'data'    => ['description' => $denah->description]
        ]);
    }

    /**
     * ✅ AJAX: Bulk update descriptions (untuk fix banyak data sekaligus)
     * Route: POST /admin/denah/bulk-update-descriptions
     */
    public function bulkUpdateDescriptions(Request $request)
    {
        $validated = $request->validate([
            'items'              => 'required|array',
            'items.*.id'         => 'required|integer|exists:denahs,id',
            'items.*.description'=> 'nullable|string|max:1000',
        ]);

        $updated = 0;
        foreach ($validated['items'] as $item) {
            $denah = Denah::find($item['id']);
            if ($denah) {
                $denah->description = $item['description'] ?? null;
                $denah->save();
                $updated++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil update deskripsi {$updated} denah"
        ]);
    }

    /**
     * Delete denah
     */
    public function destroy(Denah $denah)
    {
        $name = $denah->name;
        $denah->delete();
        
        return redirect()->route('admin.denah.index')
            ->with('success', "Titik denah '{$name}' berhasil dihapus!");
    }

    /**
     * Get list of gedung
     */
    private function getGedungList()
    {
        return [
            'Lapangan', 'Taman',
            'Gedung A', 'Gedung B', 'Gedung C', 'Gedung D', 
            'Gedung E', 'Gedung F', 'Gedung G', 'Gedung H', 
            'Gedung I', 'Gedung J', 'Gedung K', 'Gedung L'
        ];
    }
}