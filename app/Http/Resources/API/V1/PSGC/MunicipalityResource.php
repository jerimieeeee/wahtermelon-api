<?php

namespace App\Http\Resources\API\V1\PSGC;

use App\Models\V1\PSGC\Province;
use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $condition = $request->include != 'municipalities' && ! is_null($request->municipality);

        $geographic = get_class($this->geographic) == Province::class ? 'province' : 'district';
        $resource = get_class($this->geographic) == Province::class ? ProvinceResource::class : DistrictResource::class;

        return [
            'code' => $this->code,
            'name' => $this->name,
            'geo_level' => $this->geo_level,
            'income_class' => $this->income_class,
            'population' => $this->population,
            'barangays' => BarangayResource::collection($this->whenLoaded('barangays')),
            $geographic => $this->when($condition, new $resource($this->geographic)),
            'region' => $this->when($condition, new RegionResource($this->geographic->region)),
        ];
    }
}
