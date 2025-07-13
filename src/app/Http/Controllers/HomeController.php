<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class HomeController extends Controller
{
	public function index()
	{
		$products = Product::with('images')->get()->map(function ($product) {
			return [
				'id' => $product->id,
				'name' => $product->name,
				'price' => $product->price,
				'image_path' => optional($product->images->first())->image_path ?? 'no-image.png',
			];
		});

		return Inertia::render('Index', [
			'products' => $products,
		]);
	}
}
