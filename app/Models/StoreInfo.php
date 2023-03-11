<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreInfo extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'store_info';
  protected $filable = ['user_id', 'name', 'type_id', 'address'];

  public function users(){
    return $this->belongsTo(Users::class, 'user_id', 'id');
  }

  public function store_type(){
    return $this->belongsTo(StoreType::class, 'type_id', 'id');
  }

  public function order(){
    return $this->hasMany(Order::class);
  }
}
