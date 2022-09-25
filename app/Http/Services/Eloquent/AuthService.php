<?php

namespace App\Http\Services\Eloquent;

use App\Http\Repositories\Eloquent\AuthRepo;
use App\Http\Services\Interfaces\AuthServiceInterface;
use App\Models\Store;
use App\Models\User;
use App\Models\UserStore;
use Illuminate\Http\Request;
//use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthService extends AbstractService implements AuthServiceInterface
{
    protected $repo;

    public function __construct(AuthRepo $repo)
    {
        $this->repo = $repo;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'store_id'=>'required',
        ]);
        if ($validator->fails())
            return responseFail($validator->errors()->all(), 422);
        $store = Store::where('id',$request->store_id)->first();
        //check if store not exist
        if(!$store)
            return responseFail('store does not exist');
            
        $credentials = $request->only('email', 'password');
        $customClaim = ['store_id' => $request->store_id];

        $user =User::where('email',$request->email)->first();
        //check in user exist
        if(!$user)
            return responseFail('this user is not exist');
        
        $exist = UserStore::where('user_id',$user->id)->where('store_id',$request['store_id'])->first();
        //check id user registred to certain store
        if($exist)
        {
            $token = JWTAuth::customClaims($customClaim)->attempt($credentials);
            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
            }
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                  
                ]
            ]);
        }else
        return responseFail('this user is not exist on this store');

    }

    public function register(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'store_id'=>'required',
        ]);
        if ($validator->fails())
            return responseFail($validator->errors()->all(), 422);


        $data=$request->only(['name','email','password','store_id']);
        $isuser = $this->repo->findWhere('email',$request->email)->first();
        //check if user already exist
        if($isuser)
        {
            $store = Store::where('id',$data['store_id'])->first();
            //check if store not exist
            if(!$store)
                return responseFail('store does not exist');

            $exist = UserStore::where('user_id',$isuser->id)->where('store_id',$data['store_id'])->first();
             //check id user registred to certain store
            if($exist)
                {
                    return response()->json([
                        "error_msg" =>'this user is already exist in this store',
                        "status" => 'failed',
                    ]);
                }else{
                    UserStore::create([
                        'user_id'=>$isuser->id,
                        'store_id' =>$data['store_id'],
                    ]);
                    return responseSuccess($isuser);
                }

        }else{
            $store = Store::where('id',$data['store_id'])->first();
            //check if store not exist
            if(!$store)
                return responseFail('store does not exist');

                $data['password'] = bcrypt($data['password']);
                $user =$this->repo->create($data);
                UserStore::create([
                    'user_id'=>$user->id,
                    'store_id' =>$data['store_id'],
                ]);

            $token = JWTAuth::login($user);
            return response()->json([
                    'status' => 'success',
                    'message' => 'User created successfully',
                    'user' => $user,
                    'authorisation' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ]);
            }
}


}

