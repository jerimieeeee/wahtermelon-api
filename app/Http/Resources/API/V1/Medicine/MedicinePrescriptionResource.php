<?php

namespace App\Http\Resources\API\V1\Medicine;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicinePrescriptionResource extends JsonResource
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
            'prescribed_by' => $this->when(! $this->relationLoaded('prescribedBy'), $this->prescribed_by),
            'prescriber' => $this->whenLoaded('prescribedBy'),
            'consult_id' => $this->when(! $this->relationLoaded('consult'), $this->consult_id),
            'consult' => $this->whenLoaded('consult'),
            'prescription_date' => $this->prescription_date->format('Y-m-d'),
            'konsulta_medicine_code' => $this->when(! $this->relationLoaded('konsultaMedicine'), $this->konsulta_medicine_code),
            'konsulta_medicine' => $this->whenLoaded('konsultaMedicine'),
            'medicine_code' => $this->when(! $this->relationLoaded('medicine'), $this->medicine_code),
            'medicine' => $this->whenLoaded('medicine'),
            'added_medicine' => $this->added_medicine,
            'instruction_quantity' => $this->instruction_quantity,
            'dosage_quantity' => $this->dosage_quantity,
            'dosage_uom' => $this->when(! $this->relationLoaded('dosageUom'), $this->dosage_uom),
            'unit_of_measurement' => $this->whenLoaded('dosageUom'),
            'dose_regimen' => $this->when(! $this->relationLoaded('doseRegimen'), $this->dose_regimen),
            'regimen' => $this->whenLoaded('doseRegimen'),
            'medicine_purpose' => $this->when(! $this->relationLoaded('medicinePurpose'), $this->medicine_purpose),
            'purpose' => $this->whenLoaded('medicinePurpose'),
            'purpose_other' => $this->purpose_other,
            'duration_intake' => $this->duration_intake,
            'duration_frequency' => $this->when(! $this->relationLoaded('durationFrequency'), $this->duration_frequency),
            'frequency' => $this->whenLoaded('durationFrequency'),
            'quantity' => $this->quantity,
            'quantity_preparation' => $this->when(! $this->relationLoaded('quantityPreparation'), $this->quantity_preparation),
            'preparation' => $this->whenLoaded('quantityPreparation'),
            'medicine_route_code' => $this->when(! $this->relationLoaded('medicineRoute'), $this->medicine_route_code),
            'medicine_route' => $this->whenLoaded('medicineRoute'),
            'dispensing' => $this->whenLoaded('dispensing'),
            'total_dispensed' => $this->when($this->dispensing_sum_dispense_quantity, $this->dispensing_sum_dispense_quantity),
            'remarks' => $this->remarks,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
