<?php

namespace App\Http\Controllers;

use App\Models\Panorama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PanoramaController extends Controller
{
    public function index(Request $request)
    {
        $query = Panorama::query();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('scene_id', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('is_active', true);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        $allowedPerPage = [10, 25, 50, 100];
        $perPage = in_array((int) $request->get('per_page'), $allowedPerPage)
            ? (int) $request->get('per_page')
            : 10;

        $panoramas = $query
            ->orderByRaw('`order` IS NULL')
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.panorama.index', compact('panoramas'));
    }

    public function create()
    {
        $panoramas = Panorama::orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.panorama.create', compact('panoramas'));
    }

    /**
     * ✅ PERBAIKAN UTAMA DI SINI: Pesan error kustom & biarkan Laravel handle validasi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                'unique:panoramas,name',
            ],
            'scene_id' => [
                'required', 'string', 'max:255',
                'unique:panoramas,scene_id',
            ],
            'image_path' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'type' => 'required|in:360,normal,equirectangular,flat,2d,image',
            'order' => 'nullable|integer|min:0',
            'hotspots' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ], [
            'name.unique' => 'Nama panorama ini sudah ada. Silakan gunakan nama lain.',
            'scene_id.unique' => 'Scene ID ini sudah digunakan. Silakan gunakan ID lain (misal: gerbang-utama-2).',
            'image_path.max' => 'Ukuran gambar terlalu besar. Maksimal 10 MB.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['hotspots'] = $request->filled('hotspots') ? $request->hotspots : '[]';
        $validated['type'] = $this->normalizeType($validated['type']);
        $validated['image_path'] = $this->storeImageFile($request->file('image_path'));

        Panorama::create($validated);

        return redirect()->route('admin.panorama.index')
            ->with('success', 'Panorama berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $panorama = Panorama::findOrFail($id);
        $allPanoramas = Panorama::where('id', '!=', $id)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.panorama.edit', compact('panorama', 'allPanoramas'));
    }

    /**
     * ✅ PERBAIKAN UPDATE: Abaikan ID saat ini saat cek unique
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                'unique:panoramas,name,'.$id,
            ],
            'scene_id' => [
                'nullable', 'string', 'max:255',
                'unique:panoramas,scene_id,'.$id,
            ],
            'image_path' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'type' => 'required|in:360,normal,equirectangular,flat,2d,image',
            'order' => 'nullable|integer|min:0',
            'hotspots' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ], [
            'name.unique' => 'Nama panorama ini sudah ada. Silakan gunakan nama lain.',
            'scene_id.unique' => 'Scene ID ini sudah digunakan. Silakan gunakan ID lain (misal: gerbang-utama-2).',
            'image_path.max' => 'Ukuran gambar terlalu besar. Maksimal 10 MB.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['hotspots'] = $request->filled('hotspots') ? $request->hotspots : '[]';
        $validated['type'] = $this->normalizeType($validated['type']);

        $panorama = Panorama::findOrFail($id);

        if ($request->hasFile('image_path')) {
            $this->deleteImageFile($panorama->image_path);
            $validated['image_path'] = $this->storeImageFile($request->file('image_path'));
        } else {
            unset($validated['image_path']);
        }

        $panorama->update($validated);

        return redirect()->route('admin.panorama.index')
            ->with('success', 'Panorama berhasil diperbarui!');
    }

    protected function normalizeType(string $type): string
    {
        return in_array($type, ['equirectangular', '360'], true) ? '360' : 'normal';
    }

    protected function storeImageFile($file): string
    {
        $filename = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('panoramas');

        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);

        return 'panoramas/'.$filename;
    }

    protected function deleteImageFile(?string $path): void
    {
        if (! $path) {
            return;
        }

        $filePath = public_path($path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

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
            Log::error('Delete Panorama Error: '.$e->getMessage());

            return back()->with('error', 'Gagal menghapus: '.$e->getMessage());
        }
    }

    public function toggleStatus($id, Request $request)
    {
        try {
            $panorama = Panorama::findOrFail($id);
            $newStatus = ! $panorama->is_active;
            $panorama->update(['is_active' => $newStatus]);

            return response()->json(['success' => true, 'is_active' => $newStatus]);
        } catch (\Exception $e) {
            Log::error('Toggle Status Error: '.$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Gagal mengubah status'], 500);
        }
    }

    public function bulkToggle(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:panoramas,id',
                'is_active' => 'required|boolean',
            ]);

            Panorama::whereIn('id', $validated['ids'])->update(['is_active' => $validated['is_active']]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Bulk Toggle Error: '.$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Gagal mengubah status'], 500);
        }
    }

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
            Log::error('Bulk Delete Error: '.$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Gagal menghapus'], 500);
        }
    }
}
