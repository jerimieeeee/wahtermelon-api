<?php

namespace App\Http\Resources\API\V1\MaternalCare;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultMcServiceResource extends JsonResource
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
            'patient_mc_id' => $this->when(! $this->relationLoaded('patientMc'), $this->patient_mc_id),
            'patient_mc' => new PatientMcResource($this->whenLoaded('patientMc')),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'service_id' => $this->when(! $this->relationLoaded('service'), $this->service_id),
            'service' => $this->whenLoaded('service'),
            'visit_type_code' => $this->when(! $this->relationLoaded('visitType'), $this->visit_type_code),
            'visit_type' => $this->whenLoaded('visitType'),
            'visit_status' => $this->visit_status,
            'service_date' => $this->service_date->format('Y-m-d'),
            'service_qty' => $this->service_qty,
            'positive_result' => $this->positive_result,
            'intake_penicillin' => $this->intake_penicillin,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
