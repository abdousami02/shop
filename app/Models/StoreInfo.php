<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreInfo extends Model
{
  use HasFactory;

  protected $table = 'store_info';
  protected $filable = ['user_id', 'name', 'type_id', 'address'];
  protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

  public function user(){
    return $this->belongsTo(Users::class, 'user_id', 'id');
  }

  public function store_type(){
    return $this->belongsTo(StoreType::class, 'type_id', 'id');
  }

  public function order(){
    return $this->hasMany(Order::class, 'store_id', 'id');
  }
}
