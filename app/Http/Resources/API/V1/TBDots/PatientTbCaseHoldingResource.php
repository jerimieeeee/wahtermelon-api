<?php

namespace App\Http\Resources\API\V1\TBDots;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientTbCaseHoldingResource extends JsonResource
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
            'patient_tb_id' => $this->patient_tb_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'enroll_as_code' => $this->when(!$this->relationLoaded('enrollAs'), $this->enroll_as_code),
            'enroll_as' => $this->whenLoaded('enrollAs'),
            'treatment_regimen_code' => $this->when(!$this->relationLoaded('treatmentRegimen'), $this->treatment_regimen_code),
            'treatment_regimen' => $this->whenLoaded('treatmentRegimen'),
            'registration_date' => $this->registration_date->format('Y-m-d'),
            'treatment_start' => $this->treatment_start->format('Y-m-d'),
            'continuation_start' => $this->continuation_start->format('Y-m-d'),
            'treatment_end' => $this->treatment_end->format('Y-m-d'),
            'bacteriological_status_code' => $this->when(!$this->relationLoaded('bacteriologicalStatus'), $this->bacteriological_status_code),
            'bacteriological_status' => $this->whenLoaded('bacteriologicalStatus'),
            'anatomical_site_code' => $this->when(!$this->relationLoaded('anatomicalSite'), $this->anatomical_site_code),
            'anatomical_site' => $this->whenLoaded('anatomicalSite'),
            'eptb_site_id' => $this->when(!$this->relationLoaded('eptbSite'), $this->eptb_site_id),
            'eptb_site' => $this->whenLoaded('eptbSite'),
            'specific_site' => $this->specific_site,
            'drug_resistant_flag' => $this->drug_resistant_flag,
            'ipt_type_code' => $this->when(!$this->relationLoaded('iptType'), $this->ipt_type_code),
            'ipt_type' => $this->whenLoaded('iptType'),
            'transfer_flag' => $this->transfer_flag,
            'pict_date' => $this->pict_date->format('Y-m-d')
        ];
    }
}
