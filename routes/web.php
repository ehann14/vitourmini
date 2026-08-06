<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PanoramaController;
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

Route::get('/', function () {
    return view('splash');
})->name('splash');

Route::get('/denah', [DenahController::class, 'show'])->name('denah');

Route::get('/beranda', function () {
    return redirect()->route('denah');
})->name('home');

// ============================================
// 🔌 API ROUTES (Public JSON Endpoints)
// ============================================

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/denah-data', [DenahController::class, 'getData'])
        ->name('denah.data');
    
    Route::get('/denah-detail/{id}', [DenahController::class, 'showDetail'])
        ->name('denah.detail');
    
    Route::get('/panorama/{scene_id}', [HomeController::class, 'apiShow'])
        ->name('panorama.show');
});

// ============================================
// 🎥 PANORAMA VIEWER ROUTES
// ============================================

Route::get('/view/{scene_id}', [HomeController::class, 'view'])->name('view');

// ============================================
// 🔐 AUTH ROUTES (Admin Login)
// ============================================

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware('guest')->group(function () {
        
        Route::get('/login', function () {
            if (Auth::check()) {
                return redirect()->route('admin.dashboard');
            }
            return view('auth.login');
        })->name('login');

        Route::post('/login', function (Request $request) {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $login = trim($request->username);
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
    
    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });

    Route::prefix('denah')->name('denah.')->group(function () {
        Route::get('/', [DenahController::class, 'index'])->name('index');
        Route::get('/create', [DenahController::class, 'create'])->name('create');
        Route::post('/store', [DenahController::class, 'store'])->name('store');
        Route::get('/{denah}/edit', [DenahController::class, 'edit'])->name('edit');
        Route::put('/{denah}', [DenahController::class, 'update'])->name('update');
        Route::delete('/{denah}', [DenahController::class, 'destroy'])->name('destroy');
        
        Route::post('/{denah}/update-description', [DenahController::class, 'updateDescription'])
            ->name('updateDescription');
        Route::post('/bulk-update-descriptions', [DenahController::class, 'bulkUpdateDescriptions'])
            ->name('bulkUpdateDescriptions');
    });

    Route::prefix('panorama')->name('panorama.')->group(function () {
        Route::get('/', [PanoramaController::class, 'index'])->name('index');
        Route::get('/create', [PanoramaController::class, 'create'])->name('create');
        Route::post('/store', [PanoramaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PanoramaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PanoramaController::class, 'update'])->name('update');
        Route::delete('/{id}', [PanoramaController::class, 'destroy'])->name('destroy');
        
        Route::post('/{id}/toggle-status', [PanoramaController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-toggle', [PanoramaController::class, 'bulkToggle'])->name('bulk-toggle');
        Route::post('/bulk-delete', [PanoramaController::class, 'bulkDelete'])->name('bulk-delete');
    });
});

// ============================================
// 🚧 FALLBACK ROUTE (404 Custom)
// ============================================

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});