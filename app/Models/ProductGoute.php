<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGoute extends Model
{
  use HasFactory;
  protected $table = 'product_goute';
  protected $filable = ['product_id', 'goute', 'in_stock', 'discount'];
  protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

  public function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function order_detail_goute(){
    return $this->hasMany(OrderDetailtGoute::class);
  }

  // public function order_details(){
  //   return $this->hasMany(OrderDetails::class);
  // }

}
