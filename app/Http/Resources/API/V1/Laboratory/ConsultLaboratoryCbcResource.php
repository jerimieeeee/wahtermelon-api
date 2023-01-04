<?php

namespace App\Http\Resources\API\V1\Laboratory;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultLaboratoryCbcResource extends JsonResource
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
            'hemoglobin' => $this->hemoglobin,
            'hematocrit' => $this->hematocrit,
            'rbc' => $this->rbc,
            'mcv' => $this->mcv,
            'mch' => $this->mch,
            'mchc' => $this->mchc,
            'wbc' => $this->wbc,
            'neutrophils' => $this->neutrophils,
            'lymphocytes' => $this->lymphocytes,
            'basophils' => $this->basophils,
            'monocytes' => $this->monocytes,
            'eosinophils' => $this->eosinophils,
            'stab' => $this->stab,
            'juvenile' => $this->juvenile,
            'platelets' => $this->platelets,
            'reticulocytes' => $this->reticulocytes,
            'bleeding_time' => $this->bleeding_time,
            'clothing_time' => $this->clothing_time,
            'esr' => $this->esr,
            'remarks' => $this->remarks,
            'lab_status_code' => $this->when(!$this->relationLoaded('laboratoryStatus'),$this->lab_status_code),
            'lab_status' => $this->whenLoaded('laboratoryStatus'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
