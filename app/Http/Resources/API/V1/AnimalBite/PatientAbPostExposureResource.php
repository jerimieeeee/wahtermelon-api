<?php

namespace App\Http\Resources\API\V1\AnimalBite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientAbPostExposureResource extends JsonResource
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
            'weight' => $this->weight,
            'animal_status_code' => $this->when(! $this->relationLoaded('animalStatus'), $this->animal_type_id),
            'animal_status' => $this->whenLoaded('animalStatus'),
            'animal_status_date' => $this->animal_status_date,
            'rig_type_code' => $this->when(! $this->relationLoaded('rigType'), $this->animal_type_id),
            'rig_type' => $this->whenLoaded('rigType'),
            'rig_date' => $this->rig_date,
            'booster_1_flag' => $this->booster_1_flag,
            'booster_2_flag' => $this->booster_2_flag,
            'other_vacc_date' => $this->other_vacc_date,
            'other_vacc_desc' => $this->other_vacc_desc,
            'other_vacc_route_code' => $this->when(! $this->relationLoaded('otherVaccineRoute'), $this->animal_type_id),
            'other_vacc_route' => $this->whenLoaded('otherVaccineRoute'),
            'day0_date' => $this->day0_date,
            'day0_vaccine_code' => $this->when(! $this->relationLoaded('day0Vaccine'), $this->animal_type_id),
            'day0_vaccine' => $this->whenLoaded('day0Vaccine'),
            'day0_vaccine_route_code' => $this->when(! $this->relationLoaded('day0VaccineRoute'), $this->animal_type_id),
            'day0_vaccine_route' => $this->whenLoaded('day0VaccineRoute'),
            'day3_date' => $this->day3_date,
            'day3_vaccine_code' => $this->when(! $this->relationLoaded('day3Vaccine'), $this->animal_type_id),
            'day3_vaccine' => $this->whenLoaded('day3Vaccine'),
            'day3_vaccine_route_code' => $this->when(! $this->relationLoaded('day3VaccineRoute'), $this->animal_type_id),
            'day3_vaccine_route' => $this->whenLoaded('day3VaccineRoute'),
            'day7_date' => $this->day7_date,
            'day7_vaccine_code' => $this->when(! $this->relationLoaded('day7Vaccine'), $this->animal_type_id),
            'day7_vaccine' => $this->whenLoaded('day7Vaccine'),
            'day7_vaccine_route_code' => $this->when(! $this->relationLoaded('day7VaccineRoute'), $this->animal_type_id),
            'day7_vaccine_route' => $this->whenLoaded('day7VaccineRoute'),
            'day14_date' => $this->day14_date,
            'day14_vaccine_code' => $this->when(! $this->relationLoaded('day14Vaccine'), $this->animal_type_id),
            'day14_vaccine' => $this->whenLoaded('day14Vaccine'),
            'day14_vaccine_route_code' => $this->when(! $this->relationLoaded('day14VaccineRoute'), $this->animal_type_id),
            'day14_vaccine_route' => $this->whenLoaded('day14VaccineRoute'),
            'day28_date' => $this->day28_date,
            'day28_vaccine_code' => $this->when(! $this->relationLoaded('day28Vaccine'), $this->animal_type_id),
            'day28_vaccine' => $this->whenLoaded('day28Vaccine'),
            'day28_vaccine_route_code' => $this->when(! $this->relationLoaded('day28VaccineRoute'), $this->animal_type_id),
            'day28_vaccine_route' => $this->whenLoaded('day28VaccineRoute'),
        ];
    }
}
