<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'users';

  protected $filable = ['id','group_id', 'name', 'mobile', 'email',
     'image', 'permition', 'rank', 'status'];

  protected $hidden = ['password','remember_token',];

  public function group(){
    return $this->belongsTo(Group::class, 'group_id', 'id');
  }

  public function store_info(){
    return $this->hasMany(StoreInfo::class, 'user_id', 'id');
  }

}
