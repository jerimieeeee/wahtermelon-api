<?php

namespace App\Http\Resources\API\V1\MaternalCare;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultMcPostpartumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_mc_id' => $this->when(!$this->relationLoaded('patientMc'),$this->patient_mc_id),
            'patient_mc' => new PatientMcResource($this->whenLoaded('patientMc')),
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(!$this->relationLoaded('patient'),$this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'postpartum_date' => $this->postpartum_date?->format('Y-m-d'),
            'postpartum_week' => $this->postpartum_week,
            'visit_sequence' => $this->visit_sequence,
            'visit_type' => $this->visit_type,
            'breastfeeding' => $this->breastfeeding,
            'family_planning' => $this->family_planning,
            'fever' => $this->fever,
            'vaginal_infection' => $this->vaginal_infection,
            'vaginal_bleeding' => $this->vaginal_bleeding,
            'pallor' => $this->pallor,
            'cord_ok' => $this->cord_ok,
            'patient_height' => $this->patient_height,
            'patient_weight' => $this->patient_weight,
            'bp_systolic' => $this->bp_systolic,
            'bp_diastolic' => $this->bp_diastolic,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
