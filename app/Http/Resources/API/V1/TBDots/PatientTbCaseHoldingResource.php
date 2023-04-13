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
            'case_number' => $this->case_number,
            'enroll_as' => $this->when(!$this->relationLoaded('enrollAs'), $this->enrollAs),
            'treatment_regimen' => $this->when(!$this->relationLoaded('treatmentRegimen'), $this->treatmentRegimen),
            'registration_date' => $this->registration_date,
            'treatment_start' => $this->treatment_start,
            'continuation_start' => $this->continuation_start,
            'treatment_end' => $this->treatment_end,
            'bacteriological_status' => $this->when(!$this->relationLoaded('bacteriologicalStatus'), $this->bacteriologicalStatus),
            'anatomical_site' => $this->when(!$this->relationLoaded('anatomicalSite'), $this->anatomicalSite),
            'eptb_site' => $this->whenLoaded('eptbSite'),
            'specific_site' => $this->specific_site,
            'drug_resistant_flag' => $this->drug_resistant_flag,
            'ipt_type' => $this->when(!$this->relationLoaded('iptType'), $this->iptType),
            'transfer_flag' => $this->transfer_flag,
            'pict_date' => $this->pict_date
        ];
    }
}
