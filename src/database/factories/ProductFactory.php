<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
  protected $model = Product::class;

  public function definition(): array
  {
    return [
      'name' => 'テスト商品',
      'price' => 100.00,
      'stock' => 1,
      'description' => 'これはテストです。',
      'shop_id' => function () {
        return Shop::factory()->create()->id;
      },
    ];
  }
}
