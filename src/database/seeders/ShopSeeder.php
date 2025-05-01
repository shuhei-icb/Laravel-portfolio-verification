<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
	public function run(): void
	{
		DB::table('shops')->insert([
			'name' => 'テストショップ',
			'email'     => 'test-shop@example.com',
			'password' => bcrypt('password'),
			'description' => 'これはテストショップです。'
		]);
	}
}
