<?php

namespace App\Http\Services\Eloquent;

use App\Http\Repositories\Eloquent\StoreRepo;
use App\Http\Services\Eloquent\AbstractService;
use App\Http\Services\Interfaces\StoreServiceInterface;

class StoreService extends AbstractService implements StoreServiceInterface
{
    protected $repo;
    public function __construct(StoreRepo $repo)
    {
        $this->repo=$repo;
    }
    public function whereFirst($id)
    {
        $store=$this->repo->whereFirst('id',$id);
        if($store)
                return $store;
            else
                return false;
        

    }

}