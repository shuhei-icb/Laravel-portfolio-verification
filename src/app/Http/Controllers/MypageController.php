<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
	public function index()
	{
		/** @var User $user */
		$user = Auth::user();
		$user->load('address');

		return Inertia::render('Mypage/Index', [
			'user' => $user,
			'address' => $user->address,
		]);
	}

	// public function orders()
	// {
	//     $orders = Auth::user()->orders()->latest()->get(); // 関連定義が必要
	//     return Inertia::render('Mypage/Orders', [
	//         'orders' => $orders,
	//     ]);
	// }

	public function profile()
	{
		return Inertia::render('Mypage/Profile', [
			'user' => Auth::user(),
		]);
	}

	public function address()
	{
		/** @var User $user */
		$user = Auth::user();
		$user->load('address');

		return Inertia::render('Mypage/Address', [
			'user' => $user,
			'address' => $user->address,
		]);
	}
}
