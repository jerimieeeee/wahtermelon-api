<?php

namespace App\Http\Resources\API\V1\PSGC;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
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
            'facility_code' => $this->facility_code,
            'facility_name' => $this->facility_name,
            'facility_major_type' => $this->facility_major_type,
            'health_facility_type' => $this->health_facility_type,
            'ownership_classification' => $this->ownership_classification,
            'ownership_sub_classification' => $this->ownership_sub_classification,
            'service_capability' => $this->service_capability,
            'bed_capacity' => $this->bed_capacity,
            'barangay' => $this->when($this->barangay, new BarangayResource($this->barangay)),
            'municipality' => $this->when($this->municipality, new MunicipalityResource($this->municipality)),
            'province' => $this->when($this->province, new ProvinceResource($this->province)),
            'region' => $this->when($this->region, new RegionResource($this->region)),
        ];
    }
}
