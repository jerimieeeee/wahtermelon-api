<?php

namespace App\Http\Resources\API\V1\PSGC;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $condition = $request->include != 'provinces' && ! is_null($request->province) && is_null($request->city) && is_null($request->municipality);

        return [
            'code' => $this->psgc_10_digit_code,
            'name' => $this->name,
            'income_class' => $this->income_class,
            'population' => $this->population,
            'region' => $this->when($condition, new RegionResource($this->region)),
            'cities' => CityResource::collection($this->whenLoaded('cities')),
            'municipalities' => MunicipalityResource::collection($this->whenLoaded('municipalities')),
        ];
    }
}
