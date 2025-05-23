<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvSymptomsCorporalResource extends JsonResource
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
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_gbv_intake_id' => $this->when(! $this->relationLoaded('patientGbv'), $this->patient_gbv_intake_id),
            'patientGbvIntake' => $this->whenLoaded('patientGbvIntake'),
            'info_source_id' => $this->info_source_id,
            'corporal_symptoms_id' => $this->when(! $this->relationLoaded('corporal'), $this->corporal_symptoms_id),
            'symptomsCorporal' => $this->whenLoaded('corporal'),
            'remarks' => $this->remarks,
        ];
    }
}
