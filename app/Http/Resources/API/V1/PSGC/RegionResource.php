<?php

namespace App\Http\Resources\API\V1\PSGC;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'code' => $this->psgc_10_digit_code,
            'name' => $this->name,
            'population' => $this->population,
            'provinces' => ProvinceResource::collection($this->whenLoaded('provinces')),
            'districts' => DistrictResource::collection($this->whenLoaded('districts')),
        ];
    }
}
