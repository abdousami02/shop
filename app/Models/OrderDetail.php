<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
  use HasFactory;
  protected $table = 'order_details';
  protected $filable = ['order_id', 'product_id', 'product_goute_id', 'discount_id', 'qte', 'price_sell', 'price_total', 'weight'];
  protected $hidden = ['deleted_at', 'updated_at'];

  public function order(){
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }

  // public function discount(){
  //   return $this->belongsTo(Discount::class, 'discount_id');
  // }

  public function order_detail_goute(){
    return $this->hasMany(OrderDetailGoute::class);
  }

}
