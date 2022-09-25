<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\UserRepoInterface;
use App\Models\User;
use Laratrust\Traits\LaratrustUserTrait;


class UserRepo extends AbstractRepo implements UserRepoInterface
{

    public function __construct()
    {
        parent::__construct(User::class);
    }

  

}
