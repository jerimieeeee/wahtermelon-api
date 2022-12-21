<?php

namespace App\Http\Resources\API\V1\NCD;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultNcdRiskQuestionnaireResource extends JsonResource
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
            'patient_ncd_id' => $this->patient_ncd_id,
            'consult_id' => $this->consult_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'question1' => $this->question1,
            'question2' => $this->question2,
            'question3' => $this->question3,
            'question4' => $this->question4,
            'question5' => $this->question5,
            'question6' => $this->question6,
            'question7' => $this->question7,
            'question8' => $this->question8,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
