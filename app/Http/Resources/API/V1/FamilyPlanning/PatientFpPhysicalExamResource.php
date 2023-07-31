<?php

namespace App\Http\Resources\API\V1\FamilyPlanning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientFpPhysicalExamResource extends JsonResource
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
            'patient_fp_id' => $this->when(! $this->relationLoaded('patientFp'), $this->patient_fp_id),
            'patientFp' => $this->whenLoaded('patientFp'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'pe_id' => $this->when(! $this->relationLoaded('physicalExam'), $this->pe_id),
            'physicalExam' => $this->whenLoaded('physicalExam'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
