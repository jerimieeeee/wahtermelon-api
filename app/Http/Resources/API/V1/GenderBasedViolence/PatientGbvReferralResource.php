<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvReferralResource extends JsonResource
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
            'referral_facility_code' => $this->when(! $this->relationLoaded('facility'), $this->referral_facility_code),
            'referral_facility' => $this->whenLoaded('facility'),
            'referral_date' => $this->referral_date,
            'medico_legal_flag' => $this->referramedico_legal_flagl_date,
            'referral_reason' => $this->referral_reason,
            'service_remarks' => $this->service_remarks,
            'referral_remarks' => $this->referral_remarks,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
