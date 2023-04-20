<?php

namespace App\Http\Resources\API\V1\Appointment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'name' => $this->name,
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'referral_facility_code' => $this->when(! $this->relationLoaded('facility'), $this->referral_facility_code),
            'facility' => $this->whenLoaded('facility'),
            'appointment_desc' => $this->appointment_desc,
            'modules' => $this->modules,
            'appointment_date' => $this->appointment_date?->format('Y-m-d'),
        ];
    }
}
