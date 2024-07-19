<?php

namespace App\Http\Resources\API\V1\Dental;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DentalServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->notes_id,
            'facility_code' => $this->facility_code,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,

            'service_date' => $this->service_date,
            'service_id' => $this->service_id,
            'service' => $this->whenLoaded('service'),
            'remarks' => $this->remarks,
        ];
    }
}
