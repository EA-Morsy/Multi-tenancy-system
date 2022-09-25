<?php

namespace App\Http\Controllers\Api;
use App\Http\Services\Eloquent\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //
    protected $service;

    public function __construct(AuthService $Service)
    {
        $this->service = $Service;
    }

    public function register(Request $request)
    {
        return $this->service->register($request);
    }
    public function login(Request $request)
    {
        return $this->service->login($request);
    }

}
