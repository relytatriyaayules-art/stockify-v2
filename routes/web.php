<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\UserController;

Route::get('/', function () { return view('auth.login'); })->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();
        
        if ($user->hasRole('Admin')) return redirect()->route('admin.dashboard');
        if ($user->hasRole('Manager') || $user->hasRole('Manajer Gudang')) return redirect()->route('manager.dashboard');
        if ($user->hasRole('Staff Gudang')) return redirect()->route('staff.dashboard');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Dashboard Per Role
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.admin'); })->name('dashboard');
});

Route::middleware(['auth', 'role:Manager|Manajer Gudang'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.manager'); })->name('dashboard');
});

Route::middleware(['auth', 'role:Staff Gudang'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.staff'); })->name('dashboard');
});

// Operational Routes
Route::middleware(['auth'])->group(function () {
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/products/{id}/stock', [ProductController::class, 'updateStock'])->name('products.stock');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store')->middleware('role:Admin');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy')->middleware('role:Admin');

    // Categories (Admin Only)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('role:Admin');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('role:Admin');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('role:Admin');

    // User Management (Admin Only)
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('role:Admin');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('role:Admin');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('role:Admin');

    // Stock Opname
    Route::get('/stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname.index');
    Route::post('/stock-opname', [StockOpnameController::class, 'process'])->name('stock-opname.process');

    // Reports
    Route::middleware(['role:Admin|Manager|Manajer Gudang'])->group(function () {
        Route::get('/reports', [TransactionController::class, 'index'])->name('reports.index');
    });
});
