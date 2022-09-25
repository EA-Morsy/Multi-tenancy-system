<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productUserStore()
    {
        return $this->hasMany(ProductUserStore::class ,'product_id','id');
    }
}
