<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvPlacementResource extends JsonResource
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
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_gbv_intake_id' => $this->when(! $this->relationLoaded('patientGbv'), $this->patient_gbv_intake_id),
            'patientGbv' => $this->whenLoaded('patientGbv'),
            'location_id' => $this->when(! $this->relationLoaded('location'), $this->location_id),
            'location' => $this->whenLoaded('location'),
            'home_by_cpu_flag' => $this->home_by_cpu_flag,
            'home_by_other_name' => $this->home_by_other_name,
            'scheduled_date' => $this->scheduled_date,
            'actual_date' => $this->actual_date,
            'placement_name' => $this->placement_name,
            'placement_contact_info' => $this->placement_contact_info,
            'type_id' => $this->when(! $this->relationLoaded('placementType'), $this->type_id),
            'placementType' => $this->whenLoaded('placementType'),
            'hospital_name' => $this->hospital_name,
            'hospital_ward' => $this->hospital_ward,
            'hospital_date_in' => $this->hospital_date_in,
            'hospital_date_out' => $this->hospital_date_out,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
