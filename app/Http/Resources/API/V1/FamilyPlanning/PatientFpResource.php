<?php

namespace App\Http\Resources\API\V1\FamilyPlanning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientFpResource extends JsonResource
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
            'no_of_living_children_desired' => $this->no_of_living_children_desired,
            'no_of_living_children_actual' => $this->no_of_living_children_actual,
            'birth_interval_desired' => $this->birth_interval_desired,
            'average_monthly_income' => $this->average_monthly_income,
            'pe_remarks' => $this->pe_remarks,
            'history' => $this->whenLoaded('fpHistory'),
            'physical_exam' => $this->whenLoaded('fpPhysicalExam'),
            'pelvic_exam' => $this->whenLoaded('fpPelvicExam'),
            'method' => $this->whenLoaded('fpMethod'),
            'chart' => $this->whenLoaded('fpChart'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
