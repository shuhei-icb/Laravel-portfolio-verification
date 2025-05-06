<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $shop = Shop::factory()->create();

        $response = $this->actingAs($shop, 'shop')->post('/shop/products', [
            'name' => 'テスト商品',
            'price' => 1000,
            'stock' => 10,
            'description' => 'テスト商品の説明',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas(Product::class, ['name' => 'テスト商品']);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();
        $shop = Shop::find($product->shop_id);

        $response = $this->actingAs($shop, 'shop')->put("/shop/products/{$product->id}", [
            'name' => '更新後の商品名',
            'price' => 2000,
            'stock' => 5,
            'description' => '更新後の説明',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('products', ['name' => '更新後の商品名']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();
				$shop = Shop::find($product->shop_id);

        $response = $this->actingAs($shop, 'shop')->delete("/shop/products/{$product->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
