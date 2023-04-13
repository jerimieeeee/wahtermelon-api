<?php

namespace App\Http\Resources\API\V1\TBDots;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientTbCaseFindingResource extends JsonResource
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
            'source_code' => $this->when(!$this->relationLoaded('source'), $this->source),
            'reg_group' => $this->when(!$this->relationLoaded('reg_group'), $this->reg_group),
            'previous_tb_treatment_code' => $this->when(!$this->relationLoaded('previous_tb_treatment'), $this->previous_tb_treatment),
            'exposetb_flag' => $this->exposetb_flag,
            'drtb_flag' => $this->drtb_flag,
            'risk_factor1' => $this->risk_factor1,
            'risk_factor2' => $this->risk_factor2,
            'risk_factor3' => $this->risk_factor3,
            'consult_date' => $this->consult_date,
            'symptom' => $this->when($this->relationLoaded('symptom'), new PatientTbSymptomResource($this->symptom)),
            'physical_exam'  => $this->when($this->relationLoaded('physical_exam'), new PatientTbPeResource($this->physical_exam))
        ];
    }
}
