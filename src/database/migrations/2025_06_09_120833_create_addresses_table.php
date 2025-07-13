<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('addresses', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
      $table->foreignId('shop_id')->nullable()->constrained()->onDelete('cascade');

			$table->string('zipcode', 7);
			$table->string('prefecture_code', 2);
			$table->string('prefecture', 50);
			$table->string('city', 100);
			$table->string('town', 100);
			$table->string('street', 100)->nullable();
			$table->string('kana_prefecture', 50)->nullable();
			$table->string('kana_city', 100)->nullable();
			$table->string('kana_town', 100)->nullable();

			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('addresses');
	}
};
