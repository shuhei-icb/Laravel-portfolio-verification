<?php

return [
	'defaults' => [
		'guard' => env('AUTH_GUARD', 'web'),
		'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
	],

	'guards' => [
		'web' => [
			'driver' => 'session',
			'provider' => 'users',
		],
		'shop' => [
			'driver' => 'session',
			'provider' => 'shops',
		],
	],

	'providers' => [
		'users' => [
			'driver' => 'eloquent',
			'model' => App\Models\User::class,
		],
		'shops' => [
			'driver' => 'eloquent',
			'model' => App\Models\Shop::class,
		],
	],

	'passwords' => [
			'users' => [
				'provider' => 'users',
				'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
				'expire' => 60,
				'throttle' => 60,
			],
			'shops' => [
        'provider' => 'shops',
        'table' => 'password_reset_tokens',
        'expire' => 60,
    ],
	],

	'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
