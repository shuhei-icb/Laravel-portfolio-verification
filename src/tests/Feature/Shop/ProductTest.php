<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $shop = Shop::factory()->create();
        $newImageFile = UploadedFile::fake()->create('new.jpg', 500, 'image/jpeg');
        
        $response = $this->actingAs($shop, 'shop')->post('/shop/products', [
            'name' => 'テスト商品',
            'price' => 1000,
            'stock' => 10,
            'description' => 'テスト商品の説明',

            'images' => [$newImageFile],
            'captions' => ['新しい画像'],
            'sort_orders' => [0],
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas(Product::class, ['name' => 'テスト商品']);
        $this->assertDatabaseHas('product_images', [
            'product_id' => 1,
            'caption' => '新しい画像',
        ]);

        Storage::disk('public')->assertExists('products/' . $newImageFile->hashName());
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();
        $shop = Shop::find($product->shop_id);
        $existingImage = ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'products/sample.jpg',
            'caption' => '旧キャプション',
            'sort_order' => 0,
        ]);

        // 新しい画像を準備
        $newImageFile = UploadedFile::fake()->create('new.jpg', 500, 'image/jpeg');
        $updatedImageFile = UploadedFile::fake()->create('updated.jpg', 500, 'image/jpeg');

        $response = $this->actingAs($shop, 'shop')->put("/shop/products/{$product->id}", [
            'name' => '更新後の商品名',
            'price' => 2000,
            'stock' => 5,
            'description' => '更新後の説明',

            'images' => [$updatedImageFile, $newImageFile],
            'image_ids' => [$existingImage->id, ''],
            'captions' => ['更新済みキャプション', '新しい画像'],
            'sort_orders' => [0, 1],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('shop.products.show', $product));
        $this->assertDatabaseHas('products', ['name' => '更新後の商品名']);
        // 画像が2件に
        $this->assertCount(2, $product->images()->get());

         // データベースに正しく更新されたか検証
        $this->assertDatabaseHas('product_images', [
          'id' => $existingImage->id,
          'caption' => '更新済みキャプション',
        ]);

        $this->assertDatabaseHas('product_images', [
        	'product_id' => $product->id,
          'caption' => '新しい画像',
        ]);

        // ファイルが保存されているか確認
        Storage::disk('public')->assertExists('products/' . $updatedImageFile->hashName());
        Storage::disk('public')->assertExists('products/' . $newImageFile->hashName());
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
