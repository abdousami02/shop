<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;
  protected $filable = ['categorie_id', 'famille_id', 'name', 'name_ar', 'code_bare', 'description', 'image',
      'price_buy', 'qte_u/c', 'price_unit', 'price_sell1', 'price_sell2', 'price_sell3', 'qte_sell2',
      'qte-sell3', 'in_stock', 'is_active', 'has_goute', 'has_discount'];
  protected $table = 'product';

  public function categories(){
    return $this->belongsTo(Categories::class, 'categorie_id');
  }

  public function famille(){
    return $this->belongsTo(Famille::class, 'famille_id');
  }

  public function order_details(){
    return $this->hasMany(OrderDetails::class);
  }
  public function discount(){
    return $this->hasOne(Discount::class);
  }

}
