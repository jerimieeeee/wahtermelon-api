<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvResource extends JsonResource
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
            'case_number' => $this->case_number,
            'case_date' => $this->case_date,
            'outcome_date' => $this->outcome_date,
            'outcome_reason_id' => $this->when(! $this->relationLoaded('outcome_reason'), $this->outcome_reason_id),
            'outcome_reason' => $this->whenLoaded('outcome_reason'),
            'outcome_result_id' => $this->when(! $this->relationLoaded('outcome_result'), $this->outcome_result_id),
            'outcome_result' => $this->whenLoaded('outcome_result'),
            'outcome_verdict_id' => $this->when(! $this->relationLoaded('outcome_verdict'), $this->outcome_verdict_id),
            'outcome_verdict' => $this->whenLoaded('outcome_verdict'),
            'primary_complaint_id' => $this->when(! $this->relationLoaded('complaint'), $this->primary_complaint_id),
            'complaint' => $this->whenLoaded('complaint'),
            'service_id' => $this->when(! $this->relationLoaded('service'), $this->service_id),
            'service' => $this->whenLoaded('service'),
            'primary_complaint_remarks' => $this->primary_complaint_remarks,
            'service_remarks' => $this->service_remarks,
            'neglect_remarks' => $this->neglect_remarks,
            'behavioral_remarks' => $this->behavioral_remarks,
            'economic_status_id' => $this->when(! $this->relationLoaded('economic'), $this->economic_status_id),
            'economic' => $this->whenLoaded('economic'),
            'barangay_code' => $this->when(! $this->relationLoaded('barangay'), $this->barangay_code),
            'barangay' => $this->whenLoaded('barangay'),
            'address' => $this->address,
            'direction_to_address' => $this->direction_to_address,
            'guardian_name' => $this->guardian_name,
            'guardian_address' => $this->guardian_address,
            'relation_to_child_id' => $this->when(! $this->relationLoaded('relation'), $this->relation_to_child_id),
            'relation' => $this->whenLoaded('relation'),
            'guardian_contact_info' => $this->guardian_contact_info,
            'same_bed_adult_male_flag' => $this->same_bed_adult_male_flag,
            'same_bed_adult_female_flag' => $this->same_bed_adult_female_flag,
            'same_bed_child_male_flag' => $this->same_bed_child_male_flag,
            'same_bed_child_female_flag' => $this->same_bed_child_female_flag,
            'same_room_adult_female_flag' => $this->same_room_adult_female_flag,
            'same_room_child_male_flag' => $this->same_room_child_male_flag,
            'sleeping_arrangement_id' => $this->when(! $this->relationLoaded('sleepingArrangement'), $this->sleeping_arrangement_id),
            'sleepingArrangement' => $this->whenLoaded('sleepingArrangement'),
            'abuse_living_arrangement_id' => $this->when(! $this->relationLoaded('livingArrangement'), $this->abuse_living_arrangement_id),
            'livingArrangement' => $this->whenLoaded('livingArrangement'),
            'present_living_arrangement_id' => $this->when(! $this->relationLoaded('presentArrangement'), $this->present_living_arrangement_id),
            'presentArrangement' => $this->whenLoaded('presentArrangement'),
            'deleted_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
