<?php

namespace App\Http\Resources\API\V1\Childcare;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultCcdevServiceResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'service_id' => $this->service_id,
            'service_date' => !is_null($this->service_date) ? $this->service_date->format('Y-m-d') : null,
            'status_id' => $this->status_id,
            'services' => $this->whenLoaded('services'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
