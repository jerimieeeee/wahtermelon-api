<?php

namespace App\Http\Resources\API\V1\Household;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseholdEnvironmentalResource extends JsonResource
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
            'household_folder_id' => $this->household_folder_id,
            'householdFolder' => $this->whenLoaded('householdFolder'),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'number_of_families' => $this->number_of_families,
            'registration_date' => $this->registration_date,
            'effectivity_year' => $this->effectivity_year,
            'water_type_code' => $this->water_type_code,
            'waterTypes' => $this->whenLoaded('waterTypes'),
            'safety_managed_flag' => $this->safety_managed_flag,
            'sanitation_managed_flag' => $this->sanitation_managed_flag,
            'satisfaction_management_flag' => $this->satisfaction_management_flag,
            'complete_sanitation_flag' => $this->complete_sanitation_flag,
            'located_premises_flag' => $this->located_premises_flag,
            'availability_flag' => $this->availability_flag,
            'microbiological_result' => $this->microbiological_result,
            'validation_date' => $this->validation_date?->format('Y-m-d H:i:s'),
            'arsenic_result' => $this->arsenic_result,
            'arsenic_date' => $this->arsenic_date?->format('Y-m-d H:i:s'),
            'open_defecation_flag' => $this->open_defecation_flag,
            'toilet_facility_code' => $this->toilet_facility_code,
            'toiletFacility' => $this->whenLoaded('toiletFacility'),
            'toilet_shared_flag' => $this->toilet_shared_flag,

            'sw_disposed_flag' => $this->sw_disposed_flag,
            'sw_collected_flag' => $this->sw_collected_flag,
            'wm_waste_segration_flag' => $this->wm_waste_segration_flag,
            'wm_backyad_composting_flag' => $this->wm_backyad_composting_flag,
            'wm_recycling_flag' => $this->wm_recycling_flag,
            'wm_collected_flag' => $this->wm_collected_flag,
            'wm_others_flag' => $this->wm_others_flag,
            'wm_others_remarks' => $this->wm_others_remarks,

            'remarks' => $this->remarks,
            'end_sanitation_flag' => $this->end_sanitation_flag,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
