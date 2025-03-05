<?php

namespace App\Http\Resources\API\V1\Adolescent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultAsrhComprehensiveResource extends JsonResource
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
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'consult_asrh_rapid_id' => $this->when(! $this->relationLoaded('consultRapid'), $this->consult_asrh_rapid_id),
            'consult_asrh_rapid' => $this->whenLoaded('consultRapid'),
            'assessment_date' => $this->assessment_date?->format('Y-m-d'),
            'consent_flag' => $this->consent_flag,
            'lib_asrh_consent_type_id' => $this->when(! $this->relationLoaded('consentType'), $this->lib_asrh_consent_type_id),
            'consent_type' => $this->whenLoaded('consentType'),
            'consent_type_other' => $this->consent_type_other,
            'home_notes' => $this->home_notes,
            'education_notes' => $this->education_notes,
            'eating_notes' => $this->eating_notes,
            'activities_notes' => $this->activities_notes,
            'drugs_notes' => $this->drugs_notes,
            'sexuality_notes' => $this->sexuality_notes,
            'suicide_notes' => $this->suicide_notes,
            'safety_notes' => $this->safety_notes,
            'spirituality_notes' => $this->spirituality_notes,
            'risky_behavior' => $this->risky_behavior,
            'self_harm' => $this->self_harm,
            'seriously_injured' => $this->seriously_injured,
            'refused_flag' => $this->refused_flag,
            'lib_asrh_refusal_reason_id' =>$this->when(! $this->relationLoaded('refusalReason'), $this->lib_asrh_refusal_reason_id),
            'refusal_reason' => $this->whenLoaded('refusalReason'),
            'refusal_reason_other' => $this->refusal_reason_other,
            'done_flag' => $this->done_flag,
            'done_date' => $this->done_date?->format('Y-m-d'),
            'referral_date' => $this->referral_date?->format('Y-m-d'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
