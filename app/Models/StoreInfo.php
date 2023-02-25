<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInfo extends Model
{
  use HasFactory;
  protected $filable = ['user_id', 'store_name', 'store_type', 'address'];
  protected $table = 'store_info';

  public function users(){
    return $this->belongsTo(Users::class, 'user_id');
  }

  public function order(){
    return $this->hasMany(Order::class);
  }
}
