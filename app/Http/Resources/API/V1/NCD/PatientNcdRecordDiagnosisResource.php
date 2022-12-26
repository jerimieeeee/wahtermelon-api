<?php

namespace App\Http\Resources\API\V1\NCD;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientNcdRecordDiagnosisResource extends JsonResource
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
            'patient_ncd_record_id' => $this->patient_ncd_record_id,
            'consult_ncd_risk_id' => $this->consult_ncd_risk_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'diagnosis_code' => $this->diagnosis_code,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
