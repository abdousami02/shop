<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sallers extends Model
{
  use HasFactory;
  protected $filable = ['user_id', 'name', 'type', 'address', 'is_active'];
  protected $table = 'sallers';

  public function users(){
    return $this->belongsTo(Users::class, 'user_id');
  }
}
