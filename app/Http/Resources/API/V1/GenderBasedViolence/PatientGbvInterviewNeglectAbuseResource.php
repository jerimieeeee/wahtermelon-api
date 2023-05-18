<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvInterviewNeglectAbuseResource extends JsonResource
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
            'intake_id' => $this->when(! $this->relationLoaded('patientGbv'), $this->intake_id),
            'info_source_id' => $this->when(! $this->relationLoaded('infoSource'), $this->info_source_id),
            'info_source' => $this->whenLoaded('infoSource'),
            'patientGbv' => $this->whenLoaded('patientGbv'),
            'neglect_abused_id' => $this->when(! $this->relationLoaded('neglect'), $this->neglect_abused_id),
            'physicalAbused' => $this->whenLoaded('neglect'),
            'neglect_abused_remarks' => $this->neglect_abused_remarks,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
