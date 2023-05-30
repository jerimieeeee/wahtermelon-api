<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvInterviewPerpetratorResource extends JsonResource
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
            'patientGbv' => $this->whenLoaded('patientGbv'),
            'perpetrator_name' => $this->perpetrator_name,
            'perpetrator_nickname' => $this->perpetrator_nickname,
            'perpetrator_age' => $this->perpetrator_age,
            'known_to_child_flag' => $this->known_to_child_flag,
            'relation_to_child_id' => $this->when(! $this->relationLoaded('relation'), $this->relation_to_child_id),
            'relation' => $this->whenLoaded('relation'),
            'location_id' => $this->when(! $this->relationLoaded('location'), $this->location_id),
            'location' => $this->whenLoaded('location'),
            'perpetrator_address' => $this->perpetrator_address,
            'abuse_alcohol_flag' => $this->abuse_alcohol_flag,
            'abuse_drugs_flag' => $this->abuse_drugs_flag,
            'abuse_drugs_remarks' => $this->abuse_drugs_remarks,
            'abuse_others_flag' => $this->abuse_others_flag,
            'abuse_others_remarks' => $this->abuse_others_remarks,
            'abused_as_child_flag' => $this->abused_as_child_flag,
            'abused_as_spouse_flag' => $this->abused_as_spouse_flag,
            'spouse_abuser_flag' => $this->spouse_abuser_flag,
            'family_violence_flag' => $this->family_violence_flag,
            'unknown_abused_flag' => $this->unknown_abused_flag,
            'criminal_conviction_similar_flag' => $this->criminal_conviction_similar_flag,
            'criminal_conviction_other_flag' => $this->criminal_conviction_other_flag,
            'criminal_record_unknown_flag' => $this->criminal_record_unknown_flag,
            'criminal_barangay_flag' => $this->criminal_barangay_flag,
            'criminal_barangay_remarks' => $this->criminal_barangay_remarks,
            'occupation_code' => $this->occupation_code,
            'perpetrator_unknown_flag' => $this->perpetrator_unknown_flag,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
