<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
  use HasFactory;
  protected $filable = ['categorie_id', 'name', 'name_ar', 'is_active'];
  protected $table = 'famille';

  public function categories(){
    return $this->belongsTo(Categories::class, 'categorie_id');
  }

  public function product(){
    return $this->hasMany(Product::class);
  }
}
