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
            'indication_option_code' => $this->indication_option_code,
            'indication_option' => $this->whenLoaded('indicationOption'),
            'day0_date' => $this->day0_date,
            'day0_vaccine_code' => $this->day0_vaccine_code,
            'day0_vaccine' => $this->whenLoaded('day0Vaccine'),
            'day0_vaccine_route_code' => $this->day0_vaccine_route_code,
            'day0_vaccine_route' => $this->whenLoaded('day0VaccineRoute'),
            'day7_date' => $this->day7_date,
            'day7_vaccine_code' => $this->day7_vaccine_code,
            'day7_vaccine' => $this->whenLoaded('day7Vaccine'),
            'day7_vaccine_route_code' => $this->day7_vaccine_route_code,
            'day7_vaccine_route' => $this->whenLoaded('day7VaccineRoute'),
            'day21_date' => $this->day21_date,
            'day21_vaccine_code' => $this->day21_vaccine_code,
            'day21_vaccine' => $this->whenLoaded('day21Vaccine'),
            'day21_vaccine_route_code' => $this->day21_vaccine_route_code,
            'day21_vaccine_route' => $this->whenLoaded('day21VaccineRoute'),
            'remarks' => $this->remarks,
        ];
    }
}
