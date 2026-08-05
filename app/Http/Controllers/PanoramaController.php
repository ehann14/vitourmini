<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panorama;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PanoramaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Pencarian dilakukan ke SELURUH data di database (semua halaman).
     */
    public function index(Request $request)
    {
        $query = Panorama::query();

        // === PENCARIAN (mencari ke semua halaman database) ===
        // Cari di kolom: name, scene_id, dan id
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('scene_id', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // === FILTER TIPE (360 atau normal) ===
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // === FILTER STATUS ===
        // ✅ FIX: View mengirim 'aktif' / 'nonaktif', jadi cek pakai 'aktif' (bukan 'active')
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('is_active', true);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        // === PER PAGE (validasi agar aman dari input aneh) ===
        $allowedPerPage = [10, 25, 50, 100];
        $perPage = in_array((int) $request->get('per_page'), $allowedPerPage)
            ? (int) $request->get('per_page')
            : 10;

        // ✅ PENTING: withQueryString() agar parameter search, status, type, per_page
        // tetap terbawa saat admin klik pagination ke halaman 2, 3, 4, dst.
        $panoramas = $query
            ->orderByRaw('`order` IS NULL')
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->withQueryString(); // ← INI YANG MEMBUAT PENCARIAN BEKERJA KE SEMUA HALAMAN

        return view('admin.panorama.index', compact('panoramas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $panoramas = Panorama::orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.panorama.create', compact('panoramas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'scene_id' => 'required|string|max:255|unique:panoramas,scene_id',
                'image_path' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
                // ✅ FIX: Terima berbagai variasi input tipe dari frontend
                'type' => 'required|in:360,normal,equirectangular,flat,2d,image',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
                'hotspots' => 'nullable|json',
                'icon' => 'nullable|string|max:255',
            ]);

            // ✅ FIX: Normalisasi tipe agar konsisten di database ('360' atau 'normal')
            if (in_array($validated['type'], ['equirectangular', '360'])) {
                $validated['type'] = '360';
            } else {
                $validated['type'] = 'normal';
            }

            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                $destinationPath = public_path('panoramas');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $validated['image_path'] = 'panoramas/' . $filename;
            }

            Panorama::create($validated);

            return redirect()->route('admin.panorama.index')
                ->with('success', 'Panorama berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMsg = isset($e->errors()['type']) ? implode(', ', $e->errors()['type']) : 'Validasi gagal';
            return back()->with('error', $errorMsg)->withInput();
        } catch (\Exception $e) {
            Log::error('Store Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $panorama = Panorama::findOrFail($id);

        $allPanoramas = Panorama::where('id', '!=', $id)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.panorama.edit', compact('panorama', 'allPanoramas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'image_path' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
                // ✅ FIX: Terima berbagai variasi input tipe dari frontend
                'type' => 'required|in:360,normal,equirectangular,flat,2d,image',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
                'hotspots' => 'nullable|json',
                'icon' => 'nullable|string|max:255',
            ]);

            // ✅ FIX: Normalisasi tipe agar konsisten di database ('360' atau 'normal')
            if (in_array($validated['type'], ['equirectangular', '360'])) {
                $validated['type'] = '360';
            } else {
                $validated['type'] = 'normal';
            }

            $panorama = Panorama::findOrFail($id);

            if ($request->hasFile('image_path')) {
                if ($panorama->image_path && file_exists(public_path($panorama->image_path))) {
                    unlink(public_path($panorama->image_path));
                }

                $file = $request->file('image_path');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                $destinationPath = public_path('panoramas');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $validated['image_path'] = 'panoramas/' . $filename;
            } else {
                unset($validated['image_path']);
            }

            $panorama->update($validated);

            return redirect()->route('admin.panorama.index')
                ->with('success', 'Panorama berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMsg = isset($e->errors()['type']) ? implode(', ', $e->errors()['type']) : 'Validasi gagal';
            return back()->with('error', $errorMsg)->withInput();
        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal update: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $panorama = Panorama::findOrFail($id);

            if ($panorama->image_path) {
                $filePath = public_path($panorama->image_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $panorama->delete();

            return redirect()->route('admin.panorama.index')
                ->with('success', 'Panorama berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif/nonaktif via AJAX.
     * ✅ FIX: Kembalikan is_active yang baru agar frontend bisa sync
     */
    public function toggleStatus($id, Request $request)
    {
        try {
            $panorama = Panorama::findOrFail($id);

            // Toggle: balik nilai is_active saat ini
            $newStatus = !$panorama->is_active;
            $panorama->update(['is_active' => $newStatus]);

            return response()->json([
                'success'   => true,
                'is_active' => $newStatus,
            ]);
        } catch (\Exception $e) {
            Log::error('Toggle Status Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status',
            ], 500);
        }
    }

    /**
     * Bulk toggle status.
     */
    public function bulkToggle(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:panoramas,id',
                'is_active' => 'required|boolean',
            ]);

            Panorama::whereIn('id', $validated['ids'])
                ->update(['is_active' => $validated['is_active']]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Bulk Toggle Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengubah status'], 500);
        }
    }

    /**
     * Bulk delete panoramas.
     */
    public function bulkDelete(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:panoramas,id',
            ]);

            foreach ($validated['ids'] as $id) {
                $panorama = Panorama::findOrFail($id);

                if ($panorama->image_path) {
                    $filePath = public_path($panorama->image_path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $panorama->delete();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Bulk Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus'], 500);
        }
    }
}