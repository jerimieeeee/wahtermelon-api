<?php

namespace App\Http\Resources\API\V1\FamilyPlanning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientFpChartResource extends JsonResource
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
            'patient_fp_method_id' => $this->when(! $this->relationLoaded('patientFpMethod'), $this->patient_fp_method_id),
            'patientFpMethod' => $this->whenLoaded('fpMethod'),
            'source_supply_code' => $this->when(! $this->relationLoaded('source'), $this->source_supply_code),
            'source' => $this->whenLoaded('source'),
            'quantity' => $this->quantity,
            'service_date' => $this->service_date,
            'next_service_date' => $this->next_service_date,
            'remarks' => $this->remarks,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
