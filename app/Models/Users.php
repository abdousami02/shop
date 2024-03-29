<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Users extends Model
{
  use HasFactory, Notifiable;
  use SoftDeletes;

  protected $table = 'users';

  protected $filable = ['id','group_id', 'name', 'mobile', 'email',
     'image', 'permition', 'rank', 'status'];

  protected $hidden = ['password','remember_token','created_at', 'deleted_at'];

  public function group(){
    return $this->belongsTo(Group::class, 'group_id', 'id');
  }

  public function store_info(){
    return $this->hasMany(StoreInfo::class, 'user_id', 'id');
  }

  public function saller(){
    return $this->hasMany(Saller::class, 'user_id', 'id');
  }

  public function order(){
    return $this->hasMany(Order::class);
  }

  public function setting(){
    return $this->hasMany(Saller::class);
  }

}
