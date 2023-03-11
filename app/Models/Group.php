<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'group';
  protected $fillable = ['id', 'name', 'status'];
  protected $hidden = ['created_at', 'updated_at'];

  public function users(){
    return $this->hasMany('App\Models\Users', 'group_id', 'id');
  }
}
