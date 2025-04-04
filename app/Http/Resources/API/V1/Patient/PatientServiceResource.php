<?php

namespace App\Http\Resources\API\V1\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'patient' => $this->patient,
            'facility' => $this->facility,
            'service_date' => $this->service_date,
            'quantity' => $this->quantity,
            'lib_service' => $this->libService,
        ];
    }
}
