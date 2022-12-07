<?php

namespace App\Http\Resources\API\V1\Childcare;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultCcdevResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'visit_date' => $this->visit_date->format('Y-m-d'),
            'visit_ended' => $this->visit_ended,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
