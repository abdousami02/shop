<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'store_type';
    protected $fillable = ['id', 'name', 'status'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function store_info(){
      return $this->hasMany(StoreInfo::class, 'id', 'group_id');
    }
}
