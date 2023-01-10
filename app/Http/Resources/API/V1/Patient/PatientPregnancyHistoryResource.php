<?php

namespace App\Http\Resources\API\V1\Patient;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientPregnancyHistoryResource extends JsonResource
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
            'patient_id' => $this->when(!$this->relationLoaded('patient'),$this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            // 'post_partum_id' => $this->when(!$this->relationLoaded('postPartum'),$this->post_partum_id),
            // 'postPartum' => $this->whenLoaded('postPartum'),
            'gravidity' => $this->gravidity,
            'parity' => $this->parity,
            'full_term' => $this->full_term,
            'preterm' => $this->preterm,
            'abortion' => $this->abortion,
            'livebirths' => $this->livebirths,
            'delivery_type' => $this->when(!$this->relationLoaded('libPregnancyDeliveryType'),$this->delivery_type),
            'libPregnancyDeliveryType' => $this->whenLoaded('libPregnancyDeliveryType'),
            'induced_hypertension' => $this->when(!$this->relationLoaded('inducedHypertension'),$this->induced_hypertension),
            'inducedHypertension' => $this->whenLoaded('inducedHypertension'),
            'with_family_planning' => $this->when(!$this->relationLoaded('withFamilyPlanning'),$this->with_family_planning),
            'withFamilyPlanning' => $this->whenLoaded('withFamilyPlanning'),
            'pregnancy_history_applicable' => $this->when(!$this->relationLoaded('pregnancyHistoryApplicable'),$this->pregnancy_history_applicable),
            'pregnancyHistoryApplicable' => $this->whenLoaded('pregnancyHistoryApplicable'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
