<?php

namespace App\Http\Controllers\Shop\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopAuthenticatedSessionController extends Controller
{
	public function create()
	{
		return Inertia::render('Shop/Auth/Login');
	}

	public function store(Request $request)
	{
		$credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		if (Auth::guard('shop')->attempt($credentials)) {
			$request->session()->regenerate();
			$request->session()->flash('message', 'ログインしました');

			return Inertia::location('/shop/dashboard');
		}

		return back()->withErrors([
			'email' => 'ログイン情報が正しくありません。',
		]);
	}

	public function destroy(Request $request)
	{
		Auth::guard('shop')->logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return Inertia::location('/shop/login');
	}
}
