<?php

namespace App\Http\Resources\API\V1\Childcare;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultCcdevVaccineResource extends JsonResource
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
            'patient_ccdev_id' => $this->patient_ccdev_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'vaccine_id' => $this->vaccine_id,
            'vaccine_date' => $this->vaccine_date->format('Y-m-d'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
