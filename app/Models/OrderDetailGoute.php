<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailGoute extends Model
{
    use HasFactory;

    protected $table = 'order_detail_goutes';
    protected $filable = ['id', 'order_detail_id', 'product_goute_id', 'order_id', 'qte'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function order_detail(){
      return $this->belongsTo(OrderDetail::class, 'order_detail_id', 'id');
    }

    public function order(){
      return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product_goute(){
      return $this->belongsTo(ProductGoute::class);
    }

}
