<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
  use HasFactory;
  protected $filable = ['order_id', 'product_id', 'product_goute_id', 'discount_id', 'qte', 'price_sell'];
  protected $table = 'order_details';

  public function order(){
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function product_goute(){
    return $this->belongsTo(ProductGoute::class, 'product_goute_id');
  }

  public function discount(){
    return $this->belongsTo(Discount::class, 'discount_id');
  }

}
