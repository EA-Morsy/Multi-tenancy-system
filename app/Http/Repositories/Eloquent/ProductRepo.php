<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\ProductRepoInterface;
use App\Models\Product;
use App\Models\ProductUserStore;
use App\Models\UserStore;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductRepo extends AbstractRepo implements ProductRepoInterface
{
   
    public function __construct()
    {
        parent::__construct(Product::class);
    }

   public function getAllProducts()
   {
        $user=JWTAuth::user();
        $payload= JWTAuth::parseToken()->getPayload();
        $store= $payload->get('store_id');
        $userStore=UserStore::where('user_id',$user->id)->where('store_id',$store)->first();
        $product=ProductUserStore::with('product')->where('user_store_id',$userStore->id)->get();
        if($product)
        {
            return $product;
        }

   }

}