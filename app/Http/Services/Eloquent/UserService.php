<?php

namespace App\Http\Services\Eloquent;
use App\Http\Repositories\Eloquent\UserRepo;
use App\Http\Services\Eloquent\AbstractService;
use App\Http\Services\Interfaces\UserServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
class UserService extends AbstractService implements UserServiceInterface
{
    protected $repo;
    public function __construct(UserRepo $repo)
    {
        $this->repo=$repo;
    }

    public function whereFirst($id)
    {
        $user=$this->repo->whereFirst('id',$id);
        if($user)
                return $user;
            else
                return false;
        

    }

}