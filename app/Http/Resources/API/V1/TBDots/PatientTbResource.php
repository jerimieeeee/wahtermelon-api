<?php

namespace App\Http\Resources\API\V1\TBDots;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientTbResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'tb_treatment_outcome_code' => $this->when(!$this->relationLoaded('treatmentOutcome'), $this->tb_treatment_outcome_code),
            'tb_treatment_outcome' => $this->whenLoaded('treatmentOutcome'),
            'lib_tb_outcome_reason_id' => $this->when(!$this->relationLoaded('outcomeReason'), $this->lib_tb_outcome_reason_id),
            'outcome_reason' => $this->whenLoaded('outcomeReason'),
            'outcome_date' => $this->outcome_date,
            'treatment_done' => $this->treatment_done,
            'outcome_remarks' => $this->outcome_remarks,
            'case_finding' => $this->when($this->relationLoaded('tbCaseFinding'), new PatientTbCaseFindingResource($this->tbCaseFinding)),
            'symptom' => $this->when($this->relationLoaded('tbSymptom'), new PatientTbSymptomResource($this->tbSymptom)),
            'physical_exam' => $this->when($this->relationLoaded('tbPhysicalExam'), new PatientTbPeResource($this->tbPhysicalExam)),
            'case_holding' => $this->when($this->relationLoaded('tbCaseHolding'), new PatientTbCaseHoldingResource($this->tbCaseHolding)),
        ];
    }
}
