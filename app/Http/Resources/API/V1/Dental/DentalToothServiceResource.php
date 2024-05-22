<?php

namespace App\Http\Resources\API\V1\Dental;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DentalToothServiceResource extends JsonResource
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
            'consult_id' => $this->consult_id,
            'user_id' => $this->user_id,

            'tooth_number' => $this->tooth_number,
            'service_code' => $this->service_code,
            'toothService' => $this->whenLoaded('toothService'),
            'consult' => $this->whenLoaded('consult'),
            'remarks' => $this->remarks,
        ];
    }
}
