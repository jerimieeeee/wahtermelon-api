<?php

namespace App\Http\Resources\API\V1\NCD;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultNcdRiskScreeningUrineProteinResource extends JsonResource
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
            'consult_ncd_risk_id' => $this->consult_ncd_risk_id,
            'patient_id' => $this->patient_id,
            'patient_ncd_id' => $this->patient_ncd_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'date_taken' => $this->date_taken,
            'protein' => $this->protein,
            'presence_of_urine_protein' => $this->presence_of_urine_protein,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
