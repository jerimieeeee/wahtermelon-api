<?php

namespace App\Http\Resources\API\V1\Consultation;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultPeRemarksResource extends JsonResource
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
            'notes_id' => $this->consult_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'skin_remarks' => $this->skin_remarks,
            'heent_remarks' => $this->heent_remarks,
            'chest_remarks' => $this->chest_remarks,
            'neuro_remarks' => $this->neuro_remarks,
            'rectal_remarks' => $this->rectal_remarks,
            'genitourinary_remarks' => $this->genitourinary_remarks,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
