<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
  use HasFactory;
  protected $filable = ['product_id', 'start_at', 'end_at', 'price_unit', 'price'];
  protected $table = 'discount';

  public function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }
}
