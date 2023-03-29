<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibVaccineResource extends JsonResource
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

            'vaccine_id' => $this->vaccine_id,
            'vaccine_name' => $this->vaccine_name,
            'vaccine_interval' => $this->vaccine_interval,
            'vaccine_module' => $this->vaccine_module,
            'vaccine_desc' => $this->vaccine_desc,
        ];
    }
}
