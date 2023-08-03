<?php

namespace App\Http\Resources\API\V1\FamilyPlanning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientFpMethodResource extends JsonResource
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
            'enrollment_date' => $this->enrollment_date,
            'treatment_partner' => $this->treatment_partner,
            'permanent_reason' => $this->permanent_reason,
            'method_code' => $this->when(! $this->relationLoaded('method'), $this->method_code),
            'method' => $this->whenLoaded('method'),
            'client_code' => $this->when(! $this->relationLoaded('client'), $this->client_code),
            'client' => $this->whenLoaded('client'),
            'dropout_date' => $this->dropout_date,
            'dropout_reason_code' => $this->when(! $this->relationLoaded('dropout'), $this->dropout_reason_code),
            'dropout' => $this->whenLoaded('dropout'),
            'dropout_remarks' => $this->dropout_remarks,
            'dropout_flag' => $this->dropout_flag,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
