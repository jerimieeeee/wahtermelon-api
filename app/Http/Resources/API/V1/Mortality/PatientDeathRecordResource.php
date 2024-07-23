<?php

namespace App\Http\Resources\API\V1\Mortality;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientDeathRecordResource extends JsonResource
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
            'barangay_code' => $this->when(! $this->relationLoaded('barangay'), $this->barangay_code),
            'barangay' => $this->whenLoaded('barangay'),
            'date_of_death' => $this->date_of_death->format('Y-m-d H:i:s'),
            'age_years' => $this->age_years,
            'age_months' => $this->age_months,
            'age_days' => $this->age_days,
            'death_type' => $this->when(! $this->relationLoaded('deathType'), $this->death_type),
            'deathType' => $this->whenLoaded('deathType'),
            'death_place' => $this->when(! $this->relationLoaded('deathPlace'), $this->death_place),
            'deathPlace' => $this->whenLoaded('deathPlace'),
            'immediate_cause' => $this->when(! $this->relationLoaded('deathPlace'), $this->immediate_cause),
            'immediateCause' => $this->whenLoaded('immediateCause'),
            'antecedent_cause' => $this->when(! $this->relationLoaded('deathPlace'), $this->antecedent_cause),
            'antecedentCause' => $this->whenLoaded('antecedentCause'),
            'underlying_cause' => $this->when(! $this->relationLoaded('deathPlace'), $this->underlying_cause),
            'underlyingCause' => $this->whenLoaded('underlyingCause'),
            'remarks' => $this->remarks,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
