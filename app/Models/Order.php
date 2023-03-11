<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;
  protected $filable = ['id', 'store_id', 'user_id', 'saller_id', 'montant', 'num_product', 'poide', 'status'];
  protected $table = 'order';

  public function store_info(){
    return $this->belongsTo(StoreInfo::class, 'store_id', 'id');
  }

  public function user() {
    return $this->belongsTo(Users::class, 'user_id', 'id');
  }

  public function saller() {
    return $this->belongsTo(Sallers::class, 'saller_id', 'id');
  }

  public function order_details(){
    return $this->hasMany(OrderDetails::class);
  }
}
