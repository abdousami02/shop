<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
  use HasFactory;
  protected $filable = ['name', 'name_ar', 'is_active'];
  protected $table = 'categories';

  public function product(){
    return $this->hasMany(Product::class);
  }

  public function famille(){
    return $this->hasMany(Famille::class);
  }
}
