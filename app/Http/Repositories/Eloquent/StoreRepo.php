<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\StoreRepoInterface;
use App\Models\Store;

class StoreRepo extends AbstractRepo implements StoreRepoInterface
{
   
    public function __construct()
    {
        parent::__construct(Store::class);
    }

   

}