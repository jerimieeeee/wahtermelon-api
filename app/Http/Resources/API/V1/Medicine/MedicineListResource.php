<?php

namespace App\Http\Resources\API\V1\Medicine;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineListResource extends JsonResource
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
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'brand_name' => $this->brand_name,
            'medicine_code' => $this->when(! $this->relationLoaded('medicine'), $this->medicine_code),
            'medicine' => $this->whenLoaded('medicine'),
            'konsulta_medicine_code' => $this->when(! $this->relationLoaded('konsultaMedicine'), $this->konsulta_medicine_code),
            'konsulta_medicine' => $this->whenLoaded('konsultaMedicine'),
            'added_medicine' => $this->added_medicine,
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
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
