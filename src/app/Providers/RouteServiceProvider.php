<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		Route::middleware('web')
			->group(base_path('routes/web.php'));

		Route::middleware(['web', 'auth'])
			->prefix('mypage')
			->name('mypage.')
			->group(base_path('routes/user.php'));

		Route::middleware(['web', 'auth:shop'])
			->prefix('shop')
			->name('shop.')
			->group(base_path('routes/shop.php'));
	}
}
