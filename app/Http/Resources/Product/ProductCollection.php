<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;


class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
           
            
            'totalPrice' => (1-$this->discount/100)*$this->price,
           
            'rating' => ($this->reviews->count()) >0?round($this->reviews->sum('star')/$this->reviews->count()):'no rating',
            'href' => [
                'link' => route('products.show',$this->id)
            ]
        ];
    }
}
