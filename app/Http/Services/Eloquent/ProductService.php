<?php

namespace App\Http\Services\Eloquent;

use App\Http\Repositories\Eloquent\ProductRepo;
use App\Http\Services\Eloquent\AbstractService;
use App\Http\Services\Interfaces\ProductServiceInterface;
use App\Models\Product;
use App\Models\ProductUserStore;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
class ProductService extends AbstractService implements ProductServiceInterface
{
    protected $repo;
    public function __construct(ProductRepo $repo)
    {
        $this->repo=$repo;
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price'=>'required',
        ]);
        if ($validator->fails())
        return responseFail($validator->errors()->all(), 422);

        $payload= JWTAuth::parseToken()->getPayload();
        $store= $payload->get('store_id');

        $user=JWTAuth::user()->id;
        $barcode=$this->repo->generateRandomString(8);

        $product=$request->only(['name']);
        $product['barCode']=$barcode;

        $data=$this->repo->create($product);
        
         $user_store=UserStore::where('user_id',$user)->where('store_id',$store)->first();
         $item=[
            'user_store_id'=>$user_store->id,
            'price'=>$request->price,
            'product_id'=>$data->id,

         ];
        $response= ProductUserStore::create($item);
         if($response)
         {
            return responseSuccess($response);
         }


    }


    public function getAllProducts()
    {
        return $this->repo->getAllProducts();

    }

    public function updateProduct(Request $request,$id)
    {
        
        $product = [];
        $price = [];
        if($request->filled('name'))
            $product['name'] =$request->name;
        if($request->filled('price'))
            $price['price']=$request->price;
        $user=JWTAuth::user()->id;
        $payload= JWTAuth::parseToken()->getPayload();
        $store= $payload->get('store_id');
        $user_store=UserStore::where('user_id',$user)->where('store_id',$store)->first();
        $item=$this->repo->findById($id);
        
       //check if product exist 
        if($item)
        {
            
            $isrelated = ProductUserStore::where('user_store_id',$user_store->id)->where('product_id',$id)->first();
            //check if product is related to the current user store
            if($isrelated)
            {

                $productResponse  = $this->repo->update($product,$item);
                if($productResponse)
                {
                    $userStoreResponse = ProductUserStore::where('user_store_id',$user_store->id)->where('product_id',$id)->update($price);
                    if($userStoreResponse)
                    {
                        return responseSuccess($productResponse);
                    }else{
                        return responseFail('cannot update product user store');
                    }
                }else{
                    responseFail('cannot update product!!');
                }
                
            }else{
                return responseFail('this product is not related to your store');
            }

        }else{
            
            return responseFail('this product doesnt exist');
        }
    }

    public function deleteProduct($id)
    {   
        $user=JWTAuth::user()->id;
        $payload= JWTAuth::parseToken()->getPayload();
        $store= $payload->get('store_id');
        $user_store=UserStore::where('user_id',$user)->where('store_id',$store)->first();
        $item=$this->repo->findById($id);
       //check if product exist 
        if($item)
        {
            $isrelated = ProductUserStore::where('user_store_id',$user_store->id)->where('product_id',$id)->first();
            //check if product is related to the current user store
            if($isrelated)
            {
                        $response=ProductUserStore::where('user_store_id',$user_store->id)->where('product_id',$id)->delete();
                        if($response)
                        {
                            $item=Product::where('id',$id)->delete();
                            if($item)
                            {
                                return responseSuccess('deleted');
                            }
                        }else
                        {
                            return responseFail('connot delete');
                        }
                     
                       
            }else{
                return responseFail('this product is not related to your store');
            }
        }else{
            return responseFail('this product doesnt exist');
        }   
    }
}