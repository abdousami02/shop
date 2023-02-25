<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  use HasFactory;
  protected $filable = ['group_id', 'name_group'];
  protected $table = 'group';

  public function users(){
    return $this->hasMany(Users::class);
  }
}
