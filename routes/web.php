<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PanoramaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\DenahController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - SMK Negeri 11 Bandung Virtual Tour
|--------------------------------------------------------------------------
*/

// ============================================
// 🏠 PUBLIC ROUTES (Tanpa Auth)
// ============================================

// ✅ Splash screen
Route::get('/', function () {
    return view('splash');
})->name('splash');

// ✅ Halaman denah (landing page utama)
Route::get('/denah', [DenahController::class, 'show'])->name('denah');

// ✅ Beranda → redirect ke denah
Route::get('/beranda', function () {
    return redirect()->route('denah');
})->name('home');

// ============================================
// 🔌 API ROUTES (Public JSON Endpoints)
// ============================================

Route::prefix('api')->name('api.')->group(function () {
    // Data denah untuk frontend viewer
    Route::get('/denah-data', [DenahController::class, 'getData'])
        ->name('denah.data');
    
    // ✅ Debug endpoint untuk cek data denah per ID
    Route::get('/denah-detail/{id}', [DenahController::class, 'showDetail'])
        ->name('denah.detail');
    
    // Panorama viewer
    Route::get('/panorama/{scene_id}', [HomeController::class, 'apiShow'])
        ->name('panorama.show');
});

// ============================================
// 🎥 PANORAMA VIEWER ROUTES
// ============================================

Route::get('/view/{scene_id}', [HomeController::class, 'view'])->name('view');

// ============================================
// 💬 COMMENT ROUTES (Public)
// ============================================

Route::post('/kirim-komentar', [CommentController::class, 'store'])
    ->name('comment.store');

// ============================================
// 🔐 AUTH ROUTES (Admin Login) - LOGIKA LANGSUNG DI ROUTE
// ✅ Tidak pakai LoginController lagi, jadi tidak akan terpengaruh
//    file controller lama yang masih validasi 'email'.
// ============================================

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest only (belum login)
    Route::middleware('guest')->group(function () {
        
        Route::get('/login', function () {
            if (Auth::check()) {
                return redirect()->route('admin.dashboard');
            }
            return view('auth.login');
        })->name('login');

        Route::post('/login', function (Request $request) {
            // ✅ Validasi 'username', BUKAN 'email'
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $login = trim($request->username);

            // ✅ Bisa login pakai username ATAU email (otomatis detect)
            $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            if (Auth::attempt([$field => $login, 'password' => $request->password], $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->onlyInput('username');
        })->name('login.post');
    });
    
    // Logout (perlu auth)
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout')->middleware('auth');
});

// ============================================
// 👑 ADMIN ROUTES (Harus Login)
// ============================================

Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth'])
     ->group(function () {
    
    // 🔹 Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('dashboard');

    // 🔹 Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])
            ->name('edit');
        Route::put('/', [ProfileController::class, 'update'])
            ->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])
            ->name('password');
    });

    // 🔹 Denah Management (CRUD + Quick Actions)
    Route::prefix('denah')->name('denah.')->group(function () {
        // CRUD Standard
        Route::get('/', [DenahController::class, 'index'])->name('index');
        Route::get('/create', [DenahController::class, 'create'])->name('create');
        Route::post('/store', [DenahController::class, 'store'])->name('store');
        Route::get('/{denah}/edit', [DenahController::class, 'edit'])->name('edit');
        Route::put('/{denah}', [DenahController::class, 'update'])->name('update');
        Route::delete('/{denah}', [DenahController::class, 'destroy'])->name('destroy');
        
        // ✅ AJAX: Update description saja (quick fix)
        Route::post('/{denah}/update-description', [DenahController::class, 'updateDescription'])
            ->name('updateDescription');
        
        // ✅ AJAX: Bulk update descriptions
        Route::post('/bulk-update-descriptions', [DenahController::class, 'bulkUpdateDescriptions'])
            ->name('bulkUpdateDescriptions');
    });

    // 🔹 Panorama Management
    Route::prefix('panorama')->name('panorama.')->group(function () {
        // CRUD Standard
        Route::get('/', [PanoramaController::class, 'index'])->name('index');
        Route::get('/create', [PanoramaController::class, 'create'])->name('create');
        Route::post('/store', [PanoramaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PanoramaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PanoramaController::class, 'update'])->name('update');
        Route::delete('/{id}', [PanoramaController::class, 'destroy'])->name('destroy');
        
        // Quick Actions
        Route::post('/{id}/toggle-status', [PanoramaController::class, 'toggleStatus'])
            ->name('toggle-status');
        Route::post('/bulk-toggle', [PanoramaController::class, 'bulkToggle'])
            ->name('bulk-toggle');
        Route::post('/bulk-delete', [PanoramaController::class, 'bulkDelete'])
            ->name('bulk-delete');
    });

    // 🔹 Comment Management
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/', [AdminCommentController::class, 'index'])->name('index');
        Route::post('/{id}/toggle', [AdminCommentController::class, 'toggleStatus'])
            ->name('toggle');
        Route::delete('/{id}', [AdminCommentController::class, 'destroy'])
            ->name('destroy');
    });
});

// ============================================
// 🚧 FALLBACK ROUTE (404 Custom)
// ============================================

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});