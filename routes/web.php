<?php

use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PageContentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageContentController::class, 'index'])->middleware(['auth', 'verified'])->name('beranda');

Route::middleware('auth')->group(function () {
  Route::inertia('/berkas', 'Berkas');
  Route::get('/divisi/{staff}', [DivisiController::class, 'index']);
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
