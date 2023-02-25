<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
  use HasFactory;
  protected $filable = ['group_id', 'name', 'mobile', 'email', 'email_verified_at', 'password',
     'image', 'permition', 'rate', 'is_active'];
  protected $table = 'users';

  public function group_id(){
    return $this->belongsTo(Group::class);
  }

  public function store_info(){
    return $this->hasMany(StoreInfo::class);
  }

}
