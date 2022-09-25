<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\AuthRepoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepo extends AbstractRepo implements AuthRepoInterface
{

    protected function credentials(Request $request)
    {
        return [
            'uid' => $request->get('username'),
            'password' => $request->get('password'),
        ];
    }

    public function username()
    {
        return 'userName';
    }

    public function __construct()
    {

        parent::__construct(User::class);

    }

    public function login(array $data)
    {
    }

    public function logout($request)
    {

        return $request->user()->token()->revoke();
    }

    public function currentUser()
    {
        return Auth::user();
    }

    public function register(array $data)
    {
        unset($data['password_confirmation']);
        $data['password']= Hash::make($data['password']);
       return User::create($data);
    }
}
