<?php

namespace App\Http\Resources\API\V1\AnimalBite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientAbPreExposureResource extends JsonResource
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
            'indication_option_code' => $this->when(! $this->relationLoaded('indicationOption'), $this->animal_type_id),
            'indication_option' => $this->whenLoaded('indicationOption'),
            'day0_date' => $this->day0_date,
            'day0_vaccine_code' => $this->when(! $this->relationLoaded('day0Vaccine'), $this->animal_type_id),
            'day0_vaccine' => $this->whenLoaded('day0Vaccine'),
            'day0_vaccine_route_code' => $this->when(! $this->relationLoaded('day0VaccineRoute'), $this->animal_type_id),
            'day0_vaccine_route' => $this->whenLoaded('day0VaccineRoute'),
            'day7_date' => $this->day7_date,
            'day7_vaccine_code' => $this->when(! $this->relationLoaded('day7Vaccine'), $this->animal_type_id),
            'day7_vaccine' => $this->whenLoaded('day7Vaccine'),
            'day7_vaccine_route_code' => $this->when(! $this->relationLoaded('day7VaccineRoute'), $this->animal_type_id),
            'day7_vaccine_route' => $this->whenLoaded('day7VaccineRoute'),
            'day21_date' => $this->day21_date,
            'day21_vaccine_code' => $this->when(! $this->relationLoaded('day21Vaccine'), $this->animal_type_id),
            'day21_vaccine' => $this->whenLoaded('day21Vaccine'),
            'day21_vaccine_route_code' => $this->when(! $this->relationLoaded('day21VaccineRoute'), $this->animal_type_id),
            'day21_vaccine_route' => $this->whenLoaded('day21VaccineRoute'),
        ];
    }
}
