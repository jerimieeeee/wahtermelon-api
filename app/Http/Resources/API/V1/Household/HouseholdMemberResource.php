<?php

namespace App\Http\Resources\API\V1\Household;

use Illuminate\Http\Resources\Json\JsonResource;

class HouseholdMemberResource extends JsonResource
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
            'household_folder_id' => $this->household_folder_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'patient' => $this->patient,
        ];
    }
}
