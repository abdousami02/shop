<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SallerPrice extends Model
{
    use HasFactory;

    protected $table = 'saller_prices';
    protected $filable = ['id', 'saller_id', 'product_id', 'price'];
    protected $hidden = ['created_at', 'deleated_at', 'updated_at'];

    public function saller(){
      return $this->belongsTo(Saller::class);
    }

    public function product(){
      return $this->belongsTo(Product::class);
    }

}
