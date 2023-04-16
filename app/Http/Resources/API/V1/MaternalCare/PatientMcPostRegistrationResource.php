<?php

namespace App\Http\Resources\API\V1\MaternalCare;

use App\Http\Resources\API\V1\PSGC\BarangayResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientMcPostRegistrationResource extends JsonResource
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
            'post_registration_date' => $this->post_registration_date->format('Y-m-d'),
            'admission_date' => $this->admission_date->format('Y-m-d H:i:s'),
            'discharge_date' => $this->discharge_date->format('Y-m-d H:i:s'),
            'delivery_date' => $this->delivery_date->format('Y-m-d H:i:s'),
            'delivery_location' => $this->deliveryLocation,
            'barangay' => new BarangayResource($this->barangay),
            'gravidity' => $this->gravidity,
            'parity' => $this->parity,
            'full_term' => $this->full_term,
            'preterm' => $this->preterm,
            'abortion' => $this->abortion,
            'livebirths' => $this->livebirths,
            'outcome' => $this->outcome,
            'healthy_baby' => $this->healthy_baby,
            'birth_weight' => $this->birth_weight,
            'attendant' => $this->attendant,
            'breastfeeding' => $this->breastfeeding,
            'breastfed_date' => $this->breastfed_date?->format('Y-m-d'),
            'end_pregnancy' => $this->end_pregnancy,
            'postpartum_remarks' => $this->postpartum_remarks,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
