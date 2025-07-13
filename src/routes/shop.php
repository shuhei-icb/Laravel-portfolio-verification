<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ProductController as ShopProductController;

// ダッシュボード
Route::get('/dashboard', fn() => inertia('Shop/Dashboard'))->name('shop.dashboard');

// ショップ向けの商品管理
Route::resource('products', ShopProductController::class);
