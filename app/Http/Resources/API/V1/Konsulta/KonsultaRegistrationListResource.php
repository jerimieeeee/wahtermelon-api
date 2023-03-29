<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class KonsultaRegistrationListResource extends JsonResource
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
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'philhealth_id' => $this->philhealth_id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'suffix_name' => $this->suffix_name,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'membership_type_id' => $this->when(! $this->relationLoaded('membershipType'), $this->membership_type_id),
            'membership_type' => $this->whenLoaded('membershipType'),
            'member_pin' => $this->member_pin,
            'member_last_name' => $this->member_last_name,
            'member_first_name' => $this->member_first_name,
            'member_middle_name' => $this->member_middle_name,
            'member_suffix_name' => $this->member_suffix_name,
            'member_birthdate' => $this->member_birthdate,
            'member_gender' => $this->member_gender,
            'mobile_number' => $this->mobile_number,
            'landline_number' => $this->landline_number,
            'member_category' => $this->member_category,
            'member_category_desc' => $this->member_category_desc,
            'package_type_id' => $this->when(! $this->relationLoaded('packageType'), $this->package_type_id),
            'package_type' => $this->whenLoaded('packageType'),
            'assigned_date' => $this->assigned_date,
            'assigned_status_id' => $this->when(! $this->relationLoaded('assignedStatus'), $this->assigned_status_id),
            'assigned_status' => $this->whenLoaded('assignedStatus'),
            'effectivity_year' => $this->effectivity_year,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
