<?php

use App\Http\Controllers\BerkasController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PageContentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageContentController::class, 'index'])->middleware(['auth', 'verified'])->name('beranda');

Route::middleware('auth')->group(function () {
  Route::resource('berkas', BerkasController::class)->names([
    'index' => 'berkas',
    'create' => 'berkas.create',
    'store' => 'berkas.store',
    'destroy' => 'berkas.destroy',
  ]);
  Route::get('berkas/download/{id}', [BerkasController::class, 'download'])->name('berkas.download');

  Route::get('/divisi/{uri}', [DivisiController::class, 'index'])->name('staff');
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
