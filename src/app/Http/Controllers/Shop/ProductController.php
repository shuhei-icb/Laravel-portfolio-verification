<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	public function index()
	{
		$products = auth()->guard('shop')->user()->products()->latest()->get();

		return inertia('Shop/Products/Index', ['products' => $products]);
	}

	public function show(Product $product)
	{
		$product->load('images');

		return inertia('Shop/Products/Show', [
			'product' => $product,
		]);
	}

	public function create()
	{
		return inertia('Shop/Products/Create');
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'price' => 'required|numeric|min:0',
			'stock' => 'required|integer|min:0',
			'description' => 'nullable|string',
			'images.*' => 'image|max:2048',
			'captions.*' => 'nullable|string',
			'sort_orders.*' => 'integer',
		]);

		$product = Product::create([
			'name' => $validated['name'],
			'price' => $validated['price'],
			'stock' => $validated['stock'],
			'description' => $validated['description'],
			'shop_id' => auth()->guard('shop')->user()->id,
		]);

		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $i => $imageFile) {
				$path = $imageFile->store('products', 'public');

				$product->images()->create([
					'image_path' => $path,
					'caption' => $request->input("captions.$i"),
					'sort_order' => $request->input("sort_orders.$i", $i),
				]);
			}
		}

		return redirect()->route('shop.products.index')->with('message', '商品を登録しました');
	}

	public function edit(Product $product)
	{
		$this->authorizeShop($product);
		$product->load('images');

		return inertia('Shop/Products/Edit', ['product' => $product]);
	}

	public function update(Request $request, Product $product)
	{
		$this->authorizeShop($product);

		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'price' => 'required|integer|min:0',
			'stock' => 'required|integer|min:0',
			'description' => 'nullable|string',
			'images.*' => 'nullable|file|image|max:2048',
			'captions' => 'nullable|array',
			'captions.*' => 'nullable|string|max:255',
			'sort_orders' => 'nullable|array',
			'sort_orders.*' => 'nullable|integer',
			'image_ids' => 'nullable|array',
		]);

		// 商品情報を更新
		$product->update([
			'name' => $validated['name'],
			'price' => $validated['price'],
			'stock' => $validated['stock'],
			'description' => $validated['description'] ?? null,
		]);

		$imageIds = $validated['image_ids'] ?? [];
		$captions = $validated['captions'] ?? [];
		$sortOrders = $validated['sort_orders'] ?? [];
		$images = $request->file('images') ?? [];

		$handledIds = [];

		foreach ($imageIds as $index => $id) {
			$caption = $captions[$index] ?? '';
			$sortOrder = $sortOrders[$index] ?? $index;
			$file = $images[$index] ?? null;

			if ($id) {
				$image = ProductImage::find($id);
				if ($image && $image->product_id === $product->id) {
					if ($file) {
						$path = $file->store('products', 'public');
						$image->image_path = $path;
					}
					$image->caption = $caption;
					$image->sort_order = $sortOrder;
					$image->save();

					$handledIds[] = $image->id;
				}
			} elseif ($file) {
				$path = $file->store('products', 'public');
				$newImage = ProductImage::create([
					'product_id' => $product->id,
					'image_path' => $path,
					'caption' => $caption,
					'sort_order' => $sortOrder,
				]);

				$handledIds[] = $newImage->id;
			}
		}

		// 不要な画像を削除（今回送信されなかった画像は削除対象）
		$product->images()->whereNotIn('id', $handledIds)->delete();

		return redirect()
			->route('shop.products.show', $product)
			->with('success', '商品を更新しました');
	}


	public function destroy(Product $product)
	{
		$this->authorizeShop($product);
		$product->delete();

		return redirect()->route('shop.products.index')->with('message', '商品を削除しました');
	}

	private function authorizeShop(Product $product)
	{
		if ($product->shop_id !== Auth::guard('shop')->id()) {
			abort(403);
		}
	}
}
