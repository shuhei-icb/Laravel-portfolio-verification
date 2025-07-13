<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\PasswordController;

// 一般ユーザー向けマイページ
Route::get('/', [MypageController::class, 'index'])->name('index');

// プロフィール
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// パスワード変更
Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

// 住所情報
Route::get('/address', [AddressController::class, 'edit'])->name('address.edit');
Route::patch('/address', [AddressController::class, 'update'])->name('address.update');
