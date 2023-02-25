<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGoute extends Model
{
  use HasFactory;
  protected $filable = ['product_id', 'goute', 'in_stock', 'discount'];
  protected $table = 'product_goute';

  public function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function order_details(){
    return $this->hasMany(OrderDetails::class);
  }
}
