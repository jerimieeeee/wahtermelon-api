<?php

namespace App\Http\Resources\API\V1\MaternalCare;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientMcResource extends JsonResource
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
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'patient_age' => $this->patient_age,
            //'pregnancy_termination_date' => !is_null($this->pregnancy_termination_date) ? $this->pregnancy_termination_date->format('Y-m-d') : null,
            'pregnancy_termination_date' => $this->pregnancy_termination_date?->format('Y-m-d'),
            'pregnancy_termination_code' => $this->when(! $this->relationLoaded('pregnancyTermination'), $this->pregnancy_termination_code),
            'pregnancy_termination' => $this->whenLoaded('pregnancyTermination'),
            'pregnancy_termination_cause' => $this->pregnancy_termination_cause,
            'pre_registration' => $this->when($this->relationLoaded('preRegister'), new PatientMcPreRegistrationResource($this->preRegister)),
            'post_registration' => $this->when($this->relationLoaded('postRegister'), new PatientMcPostRegistrationResource($this->postRegister)),
            'prenatal_visit' => $this->when($this->relationLoaded('prenatal'), ConsultMcPrenatalResource::collection($this->prenatal)),
            'postpartum_visit' => $this->when($this->relationLoaded('postpartum'), ConsultMcPostpartumResource::collection($this->postpartum)),
            'risk_factor' => $this->when($this->relationLoaded('riskFactor'), ConsultMcRiskResource::collection($this->riskFactor)),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
