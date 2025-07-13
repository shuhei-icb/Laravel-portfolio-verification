<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $fillable = [
		'user_id',
		'shop_id',
		'zipcode',
		'prefecture_code',
		'prefecture',
		'city',
		'town',
		'street',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function shop()
	{
		return $this->belongsTo(Shop::class);
	}
}
