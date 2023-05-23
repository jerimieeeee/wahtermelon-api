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
            'gbvNeglect' => $this->whenLoaded('gbvNeglect'),
            'gbvComplaint' => $this->whenLoaded('gbvComplaint'),
            'gbvBehavior' => $this->whenLoaded('gbvBehavior'),
            'gbvReferral' => $this->whenLoaded('gbvReferral'),
            'gbvIntake' => $this->whenLoaded('gbvIntake'),
            // 'gbvInterview' => $this->whenLoaded('gbvInterview'),
            'gbv_date' => $this->gbv_date,
            'gbv_complaint_remarks' => $this->gbv_complaint_remarks,
            'gbv_behavioral_remarks' => $this->gbv_behavioral_remarks,
            'gbv_neglect_remarks' => $this->gbv_neglect_remarks,
            'outcome_date' => $this->outcome_date,
            'outcome_reason_id' => $this->outcome_reason_id,
            'outcome_reason' => $this->whenLoaded('outcomeReason'),
            'outcome_result_id' => $this->outcome_result_id,
            'outcome_result' => $this->whenLoaded('outcomeResult'),
            'outcome_verdict_id' => $this->outcome_verdict_id,
            'outcome_verdict' => $this->whenLoaded('outcomeVerdict'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
