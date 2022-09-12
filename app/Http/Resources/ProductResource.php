<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function stockStatus($count){
        $status = '';
        if($count > 10){
            $status = 'avaliable';
        }else if($count > 0){
            $status = 'few';
        }else if($count === 0){
            $status = 'out of stock';
        }

        return $status;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
            return [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'show_price'=> $this->price.' mmk',
                'stock' => $this->stock,
                'stock_status' => $this->stockStatus($this->stock),
                'date' => $this->created_at->format('D M Y'),
                'time' => $this->created_at->format('h:i A'),
                'owner' => new UserResource($this->user),
                'photos' => PhotoResource::collection($this->photos)
            ];
    }
}
