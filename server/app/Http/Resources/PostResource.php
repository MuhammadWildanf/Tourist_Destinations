<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'wisata' => $this->wisata,
            'price' => $this->price,
            'openTime' => $this->openTime,
            'closeTime' => $this->closeTime,
            'access' => $this->access,
            'address' => $this->address,
            'kecamatan' => $this->kecamatan,
            'numberPhone' => $this->numberPhone,
            'img' => $this->img,
            'img_location' => $this->img,
            'status' => $this->status,
            'region_id' => $this->region_id,
            'business_id' => $this->business_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'user' => $this->user,
            
        ];
    }
}
