<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'categories';
  protected $filable = ['name', 'name_ar', 'status'];
  protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

  public function product(){
    return $this->hasMany(Product::class);
  }

  public function famille(){
    return $this->hasMany(Famille::class);
  }
}
