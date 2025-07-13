<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// トップページ
Route::get('/', [HomeController::class, 'index'])->name('index');

// 認証ルート（Laravel Breeze/Fortify等）
require __DIR__ . '/auth.php';
