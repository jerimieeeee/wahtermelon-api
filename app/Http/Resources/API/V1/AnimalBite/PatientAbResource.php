<?php

namespace App\Http\Resources\API\V1\AnimalBite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientAbResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,

            'consult_date' => $this->consult_date,
            'exposure_date' => $this->exposure_date,
            'ab_treatment_outcome_id' => $this->ab_treatment_outcome_id,
            'ab_treatment_outcome' => $this->whenLoaded('treatmentOutcome'),
            'date_outcome' => $this->date_outcome,
            'ab_death_place_id' => $this->ab_death_place_id,
            'ab_death_place' => $this->whenLoaded('deathPlace'),
            'manifestations' => $this->manifestations,
            'date_onset' => $this->date_onset,
            'date_died' => $this->date_died,
            'death_remarks' => $this->death_remarks,

            'abExposure' => $this->whenLoaded('abExposure'),
            'abPostExposure' => $this->whenLoaded('abPostExposure'),
        ];
    }
}
