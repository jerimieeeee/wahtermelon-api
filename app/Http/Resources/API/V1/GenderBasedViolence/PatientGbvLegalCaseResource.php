<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvLegalCaseResource extends JsonResource
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

            'complaint_filed_flag' => $this->complaint_filed_flag,
            'filing_type_id ' => $this->whenLoaded('filedType'),
            'nps_docket_number' => $this->nps_docket_number,
            'nps_status_id ' => $this->whenLoaded('npsStatus'),
            'filed_by_name' => $this->filed_by_name,
            'filed_by_relation_id' => $this->filed_by_relation_id,
            // 'filedRelation' => $this->whenLoaded('relation'),
            'filed_location_id ' => $this->filed_location_id,
            // 'filedLocation' => $this->whenLoaded('filedLocation'),
            'filed_location_remarks' => $this->filed_location_remarks,
            'case_initiated_flag' => $this->case_initiated_flag,
            'judge_name' => $this->judge_name,
            'court_name' => $this->court_name,
            'verdict_id' => $this->verdict_id,
            'blotter_filed_flag' => $this->verdict_id,
            'blotter_remarks' => $this->verdict_id,
            // 'verdict' => $this->whenLoaded('verdict'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
