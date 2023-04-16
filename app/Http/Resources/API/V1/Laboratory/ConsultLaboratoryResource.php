<?php

namespace App\Http\Resources\API\V1\Laboratory;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultLaboratoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lab_result = match ($this->lab_code) {
            'CBC' => 'cbc',
            'CRTN' => 'creatinine',
            'CXRAY' => 'chestXray',
            'ECG' => 'ecg',
            'FBS' => 'fbs',
            'RBS' => 'rbs',
            'HBA' => 'hba1c',
            'PSMR' => 'papsmear',
            'PPD' => 'ppd',
            'SPTM' => 'sputum',
            'FCAL' => 'fecalysis',
            'LPFL' => 'lipiProfile',
            'URN' => 'urinalysis',
            'OGTT' => 'oralGlucose',
            'FOBT' => 'fecalOccult',
            'GRMS' => 'gramStain',
            'MCRP' => 'microscopy'
        };

        return [
            'id' => $this->id,
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'consult_id' => $this->when(! $this->relationLoaded('consult'), $this->consult_id),
            'consult' => $this->whenLoaded('consult'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'request_date' => $this->request_date->format('Y-m-d'),
            'lab_code' => $this->when(! $this->relationLoaded('laboratory'), $this->lab_code),
            'laboratory' => $this->whenLoaded('laboratory'),
            'lab_result' => $this->whenLoaded($lab_result),
            'recommendation_code' => $this->when(! $this->relationLoaded('recommendation'), $this->recommendation_code),
            'recommendation' => $this->whenLoaded('recommendation'),
            'request_status_code' => $this->when(! $this->relationLoaded('requestStatus'), $this->request_status_code),
            'request_status' => $this->whenLoaded('requestStatus'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
