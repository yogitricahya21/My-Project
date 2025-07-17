<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InboundTransactionController;
use App\Http\Controllers\Admin\OutboundTransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Admin Routes ---
    Route::prefix('admin')->name('admin.')->group(function () {
        // Rute untuk Kategori Barang
        Route::resource('categories', CategoryController::class);

        // Rute untuk Lokasi Penyimpanan
        Route::resource('storage-locations', StorageLocationController::class);

        // Rute untuk Barang (Items)
        Route::resource('items', ItemController::class);

        // ... dalam Route::prefix('admin')->name('admin.')->group(function () { ...
        Route::resource('outbound-transactions', OutboundTransactionController::class)->except(['edit', 'update']);

        // ... dalam Route::prefix('admin')->name('admin.')->group(function () { ...
        Route::resource('inbound-transactions', InboundTransactionController::class)->except(['edit', 'update']);
    });
});

require __DIR__ . '/auth.php';
