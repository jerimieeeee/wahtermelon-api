<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvFamilyCompositionResource extends JsonResource
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
            'patient_gbv_id' => $this->when(! $this->relationLoaded('patientGbv'), $this->patient_gbv_id),
            'patientGbv' => $this->whenLoaded('patientGbv'),
            'name' => $this->name,
            'child_relation_id' => $this->when(! $this->relationLoaded('relation'), $this->child_relation_id),
            'relation' => $this->whenLoaded('relation'),
            'living_with_child_flag' => $this->living_with_child_flag,
            'age' => $this->age,
            'gender' => $this->gender,
            'civil_status_code' => $this->civil_status_code,
            'employed_flag' => $this->employed_flag,
            'occupation_code' => $this->occupation_code,
            'education_code' => $this->education_code,
            'weekly_income' => $this->weekly_income,
            'school' => $this->school,
            'company' => $this->company,
            'contact_information' => $this->contact_information,
            'deleted_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
