<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;
  protected $table = 'order';
  protected $filable = ['id', 'store_id', 'user_id', 'saller_id', 'amount', 'num_product', 'weight', 'status'];
  protected $hidden = ['deleted_at', 'updated_at'];

  public function store_info(){
    return $this->belongsTo(StoreInfo::class, 'store_id', 'id');
  }

  public function user() {
    return $this->belongsTo(Users::class);
  }

  public function saller() {
    return $this->belongsTo(Saller::class);
  }

  public function order_detail(){
    return $this->hasMany(OrderDetails::class);
  }
}
