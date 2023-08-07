<?php

namespace App\Http\Resources\API\V1\AnimalBite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientAbExposureResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'patient_ab_id' => $this->patient_ab_id,
            'animal_type_id' => $this->animal_type_id,
            'animal_type' => $this->whenLoaded('animalType'),
            'animal_type_remarks' => $this->animal_type_remarks,
            'exposure_place' => $this->exposure_place,
            'bite_flag' => $this->bite_flag,
            'animal_ownership_id' => $this->animal_ownership_id,
            'animal_ownership' => $this->whenLoaded('animalOwnership'),
            'feet_flag' => $this->feet_flag,
            'leg_flag' => $this->leg_flag,
            'arms_flag' => $this->arms_flag,
            'hand_flag' => $this->hand_flag,
            'knee_flag' => $this->knee_flag,
            'neck_flag' => $this->neck_flag,
            'head_flag' => $this->head_flag,
            'others_flag' => $this->others_flag,
            'al_remarks' => $this->al_remarks,
            'exposure_type_code' => $this->exposure_type_code,
            'exposure_type' => $this->whenLoaded('exposureType'),
            'wash_flag' => $this->wash_flag,
            'pep_flag' => $this->pep_flag,
            'tandok_name' => $this->tandok_name,
            'tandok_addresss' => $this->tandok_addresss,
            'remarks' => $this->remarks
        ];
    }
}
