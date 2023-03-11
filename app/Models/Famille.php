<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Famille extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'familles';
  protected $filable = ['name', 'name_ar', 'status'];
  protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

  public function categorie(){
    return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
  }

  public function product(){
    return $this->hasMany(Product::class);
  }
}
