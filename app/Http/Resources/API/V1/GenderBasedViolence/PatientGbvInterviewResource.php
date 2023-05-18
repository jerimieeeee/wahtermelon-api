<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvInterviewResource extends JsonResource
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
            'patient_gbv_intake_id' => $this->when(! $this->relationLoaded('patientGbv'), $this->patient_gbv_intake_id),
            'patientGbv' => $this->whenLoaded('patientGbv'),
            'info_source_code' => $this->info_source_code,
            'incident_first_datetime' => $this->incident_first_datetime,
            'incident_first_remarks' => $this->incident_first_remarks,
            'incident_recent_datetime' => $this->incident_recent_datetime,
            'incident_recent_remarks' => $this->incident_recent_remarks,
            'disclosed_flag' => $this->disclosed_flag,
            'disclosed_type' => $this->when(! $this->relationLoaded('disclosed'), $this->disclosed_type),
            'disclosed' => $this->whenLoaded('disclosed'),
            'abused_episode_id' => $this->when(! $this->relationLoaded('abusedEpisode'), $this->abused_episode_id),
            'abusedEpisode' => $this->whenLoaded('abusedEpisode'),
            'abused_episode_count' => $this->abused_episode_count,
            'abused_site_id' => $this->when(! $this->relationLoaded('abusedSite'), $this->abused_site_id),
            'abusedSite' => $this->whenLoaded('abusedSite'),
            'abused_site_remarks' => $this->abused_site_remarks,
            'abused_site_remarks_address' => $this->abused_site_remarks_address,
            'initial_disclosure' => $this->initial_disclosure,
            'witnessed_flag' => $this->witnessed_flag,
            'relation_to_child' => $this->when(! $this->relationLoaded('relation'), $this->relation_to_child),
            'relation' => $this->whenLoaded('relation'),
            'child_behavior_id' => $this->when(! $this->relationLoaded('behavior'), $this->child_behavior_id),
            'behavior' => $this->whenLoaded('behavior'),
            'child_behavior_remarks' => $this->child_behavior_remarks,
            'dev_screening_remarks' => $this->dev_screening_remarks,
            'source_from_historian_flag' => $this->source_from_historian_flag,
            'source_from_sworn_statement_flag' => $this->source_from_sworn_statement_flag,
            'source_from_victim_flag' => $this->source_from_victim_flag,
            'mental_age_id' => $this->mental_age_id,
            'child_caretaker_present_flag' => $this->child_caretaker_present_flag,
            'dev_screening_id' => $this->dev_screening_id,
            'disclosed_relation_id' => $this->disclosed_relation_id,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
