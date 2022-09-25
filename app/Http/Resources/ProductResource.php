<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            "product_name"=>$this->product->name,
            "BarCode"=>$this->product->barCode,
            "Product_price"=>$this->price,
        ];
    }
}