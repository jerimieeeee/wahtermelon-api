<?php

namespace App\Http\Resources\API\V1\Laboratory;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultLaboratoryOralGlucoseResource extends JsonResource
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
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'consult_id' => $this->when(!$this->relationLoaded('consult'),$this->consult_id),
            'consult' => $this->whenLoaded('consult'),
            'patient_id' => $this->when(!$this->relationLoaded('patient'),$this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'laboratory_date' => $this->laboratory_date->format('Y-m-d'),
            'request_id' => $this->when(!$this->relationLoaded('laboratoryRequest'),$this->request_id),
            'request' => $this->whenLoaded('laboratoryRequest'),
            'fasting_exam_mg' => $this->fasting_exam_mg,
            'fasting_exam_mmol' => $this->fasting_exam_mmol,
            'ogtt_one_hour_mg' => $this->ogtt_one_hour_mg,
            'ogtt_one_hour_mmol' => $this->ogtt_one_hour_mmol,
            'ogtt_two_hour_mg' => $this->ogtt_two_hour_mg,
            'ogtt_two_hour_mmol' => $this->ogtt_two_hour_mmol,
            'remarks' => $this->remarks,
            'lab_status_code' => $this->when(!$this->relationLoaded('laboratoryStatus'),$this->lab_status_code),
            'lab_status' => $this->whenLoaded('laboratoryStatus'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
