<?php

namespace App\Http\Resources\API\V1\Medicine;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicineDispensingResource extends JsonResource
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
            'dispensing_date' => $this->dispensing_date->format('Y-m-d'),
            'prescription_id' => $this->when(! $this->relationLoaded('prescription'), $this->prescription_id),
            'prescription' => $this->when($this->relationLoaded('prescription'), new MedicinePrescriptionResource($this->prescription->load('konsultaMedicine', 'medicine', 'dosageUom', 'doseRegimen', 'medicinePurpose', 'durationFrequency', 'quantityPreparation', 'prescribedBy', 'dispensing'))),
            'dispense_quantity' => $this->dispense_quantity,
            'unit_price' => $this->unit_price,
            'total_amount' => $this->total_amount,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
