<?php

use App\Http\Controllers\PageContentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageContentController::class, 'index']);
