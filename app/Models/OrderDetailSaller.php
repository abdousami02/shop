<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailSaller extends Model
{
    use HasFactory;

  protected $table = 'order_detail_sallers';
  protected $filable = ['id', 'saller_id', 'order_id', 'order_detail_id',  'product_id', 'price', 'ise_edite', 'qte', 'in_stock'];
  protected $hidden = [ 'updated_at'];

  public function saller(){
    return $this->belongsTo(Saller::class, 'saller_id');
  }

  public function order(){
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function order_detail(){
    return $this->belongsTo(OrderDetail::class, 'order_detail_id');
  }

  public function order_detail_goute(){
    return $this->hasMany(OrderDetailGoute::class, 'order_detail_id', 'order_detail_id');
  }

  public function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }

}
