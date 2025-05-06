<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	public function index()
	{
		$products = Auth::guard('shop')->user()->products()->latest()->get();

		return inertia('Shop/Products/Index', ['products' => $products]);
	}

	public function create()
	{
		return inertia('Shop/Products/Create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'price' => 'required|numeric|min:0',
			'stock' => 'required|integer|min:0',
		]);

		Auth::guard('shop')->user()->products()->create($request->all());

		return redirect()->route('shop.products.index')->with('message', '商品を登録しました');
	}

	public function edit(Product $product)
	{
		$this->authorizeShop($product);

		return inertia('Shop/Products/Edit', ['product' => $product]);
	}

	public function update(Request $request, Product $product)
	{
		$this->authorizeShop($product);

		$request->validate([
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'price' => 'required|numeric|min:0',
			'stock' => 'required|integer|min:0',
		]);

		$product->update($request->all());

		return redirect()->route('shop.products.index')->with('message', '商品を更新しました');
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
