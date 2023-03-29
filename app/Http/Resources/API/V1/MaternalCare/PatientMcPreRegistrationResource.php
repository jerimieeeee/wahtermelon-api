<?php

namespace App\Http\Resources\API\V1\MaternalCare;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientMcPreRegistrationResource extends JsonResource
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
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'pre_registration_date' => $this->pre_registration_date->format('Y-m-d'),
            'lmp_date' => $this->lmp_date->format('Y-m-d'),
            'edc_date' => $this->edc_date->format('Y-m-d'),
            'trimester1_date' => $this->trimester1_date->format('Y-m-d'),
            'trimester2_date' => $this->trimester2_date->format('Y-m-d'),
            'trimester3_date' => $this->trimester3_date->format('Y-m-d'),
            'postpartum_date' => $this->postpartum_date->format('Y-m-d'),
            'initial_gravidity' => $this->initial_gravidity,
            'initial_parity' => $this->initial_parity,
            'initial_full_term' => $this->initial_full_term,
            'initial_preterm' => $this->initial_preterm,
            'initial_abortion' => $this->initial_abortion,
            'initial_livebirths' => $this->initial_livebirths,
            'prenatal_remarks' => $this->prenatal_remarks,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),

        ];
    }
}
