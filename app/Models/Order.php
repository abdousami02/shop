<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;
  protected $filable = ['store_id', 'montant', 'num_product', 'poide', 'status'];
  protected $table = 'order';

  public function store_info(){
    return $this->belongsTo(StoreInfo::class, 'store_id');
  }

  public function order_details(){
    return $this->hasMany(OrderDetails::class);
  }
}
