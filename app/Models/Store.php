<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

     protected $guarded = [];

     public function userStore()
     {
        return $this->hasMany(UserStore::class , 'store_id','id');
     }
}

