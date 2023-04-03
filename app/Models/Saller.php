<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saller extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $table = 'sallers';
  protected $filable = ['id', 'user_id', 'name', 'type', 'address', 'is_active'];
  protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

  public function user(){
    return $this->belongsTo(Users::class);
  }

  public function order(){
    return $this->hasMany(Order::class, 'saller_id', 'id');
  }
}
