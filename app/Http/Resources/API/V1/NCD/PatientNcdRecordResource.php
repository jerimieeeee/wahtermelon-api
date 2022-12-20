<?php

namespace App\Http\Resources\API\V1\NCD;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientNcdRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_ncd_id' => $this->patient_ncd_id,
            'consult_ncd_risk_id' => $this->consult_ncd_risk_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'consultation_date' => $this->consultation_date,
            'current_medications' => $this->current_medications,
            'palpitation_heart' => $this->palpitation_heart,
            'peripheral_pulses' => $this->peripheral_pulses,
            'abdomen' => $this->abdomen,
            'heart' => $this->heart,
            'lungs' => $this->lungs,
            'sensation_feet' => $this->sensation_feet,
            'other_findings' => $this->other_findings,
            'other_info' => $this->other_info,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'ncdRecordDiagnosis' => $this->whenLoaded('ncdRecordDiagnosis'),
            'ncdRecordTargetOrgan' => $this->whenLoaded('ncdRecordTargetOrgan'),
            'ncdRecordCounselling' => $this->whenLoaded('ncdRecordCounselling'),
        ];
    }
}
