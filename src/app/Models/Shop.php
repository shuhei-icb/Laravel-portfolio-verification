<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Product;

class Shop extends Authenticatable
{
  use HasFactory;
  protected $fillable = ['name', 'email', 'password'];

  public function products()
  {
      return $this->hasMany(Product::class);
  }
}
