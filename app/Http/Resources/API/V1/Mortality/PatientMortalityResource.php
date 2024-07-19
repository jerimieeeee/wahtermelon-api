<?php

namespace App\Http\Resources\API\V1\Mortality;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientMortalityResource extends JsonResource
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
            'barangay_code' => $this->barangay_code,
            'death_date' => $this->death_date->format('Y-m-d'),
            'death_type' => $this->whenLoaded('deathType'),
            'death_place' => $this->whenLoaded('deathPlace'),
            'immediate_cause' => $this->immediate_cause,
            'antecedent_cause' => $this->antecedent_cause,
            'underlying_cause' => $this->underlying_cause,
            'death_remarks' => $this->death_remarks,
        ];
    }
}
