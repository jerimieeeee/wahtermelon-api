<?php

namespace App\Http\Resources\API\V1\PSGC;

use App\Models\V1\PSGC\District;
use App\Models\V1\PSGC\Province;
use App\Models\V1\PSGC\Region;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    protected $geographics = [
        District::class => [
            'resource' => DistrictResource::class,
            'index'    => 'district',
        ],
        Province::class => [
            'resource' => ProvinceResource::class,
            'index'    => 'province',
        ],
        Region::class => [
            'resource' => RegionResource::class,
            'index'    => 'region',
        ],
    ];
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $geographic = $this->geographics[get_class($this->geographic)];
        $resource = $geographic['resource'];
        $index = $geographic['index'];

        $condition = $request->include != 'cities'  && ! is_null($request->city);

        $region = get_class($this->geographic) != Region::class ? $this->geographic->region : $this->geographic;

        return [
            'code'               => $this->code,
            'name'               => $this->name,
            'city_class'         => $this->city_class,
            'income_class'       => $this->income_class,
            'population'         => $this->population,
            'barangays'          => BarangayResource::collection($this->whenLoaded('barangays')),
            'sub_municipalities' => SubMunicipalityResource::collection($this->whenLoaded('subMunicipalities')),
            $index               => $this->when($condition, new $resource($this->geographic)),
            'region'             => $this->when($condition, new RegionResource($region)),
        ];
    }
}
