<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'totalPrice' => (1-$this->discount/100)*$this->price,
            'discount' => $this->discount,
            'rating' => ($this->reviews->count()) >0?round($this->reviews->sum('star')/$this->reviews->count()):'no rating',
            'href' => [
                'reviews' => route('reviews.index',$this->id)
            ]
        ];
    }
}
