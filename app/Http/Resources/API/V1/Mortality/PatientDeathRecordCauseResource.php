<?php

namespace App\Http\Resources\API\V1\Mortality;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientDeathRecordCauseResource extends JsonResource
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
            'death_record_id' => $this->death_record_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'icd10_code' => $this->when(! $this->relationLoaded('icd10'), $this->icd10_code),
            'icd10' => $this->whenLoaded('icd10'),
            'cause_code' => $this->when(! $this->relationLoaded('cause'), $this->cause_code),
            'cause' => $this->whenLoaded('cause'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
