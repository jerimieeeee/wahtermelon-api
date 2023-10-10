<?php

namespace App\Http\Resources\API\V1\Laboratory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultLaboratoryMalariaRdtResource extends JsonResource
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
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'consult_id' => $this->when(! $this->relationLoaded('consult'), $this->consult_id),
            'consult' => $this->whenLoaded('consult'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->when($this->relationLoaded('user'), $this->user->first_name.' '.$this->user->middle_name.' '.$this->user->last_name),
            'laboratory_date' => $this->laboratory_date->format('Y-m-d'),
            'referral_facility' => $this->referral_facility,
            'request_id' => $this->when(! $this->relationLoaded('laboratoryRequest'), $this->request_id),
            'request' => $this->whenLoaded('laboratoryRequest'),
            'parasite_type' => $this->when(! $this->relationLoaded('parasiteType'), $this->parasite_type),
            'parasiteType' => $this->whenLoaded('parasiteType'),
            'rdt_number' => $this->rdt_number,
            'remarks' => $this->remarks,
            'lab_status_code' => $this->when(! $this->relationLoaded('laboratoryStatus'), $this->lab_status_code),
            'lab_status' => $this->whenLoaded('laboratoryStatus'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
