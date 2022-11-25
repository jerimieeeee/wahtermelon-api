<?php

namespace App\Http\Resources\API\V1\Patient;

use App\Http\Resources\API\V1\Household\HouseholdFolderResource;
use App\Http\Resources\API\V1\Household\HouseholdMemberResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'suffix_code' => $this->when(!$this->relationLoaded('suffixName'),$this->suffix_name),
            'suffix_name' => $this->whenLoaded('suffixName'),
            'birthdate' => !is_null($this->birthdate) ? $this->birthdate->format('Y-m-d') : null,
            'mothers_name' => $this->mothers_name,
            'gender' => $this->gender,
            'mobile_number' => $this->mobile_number,
            'pwd_type_code' => $this->when(!$this->relationLoaded('pwdType'),$this->pwd_type_code),
            'pwd_types' => $this->whenLoaded('pwdType'),
            'indegenous_flag' => $this->indegenous_flag,
            'blood_type_code' => $this->blood_type_code,
            'religion_code' => $this->when(!$this->relationLoaded('religion'),$this->religion_code),
            'religion' => $this->whenLoaded('religion'),
            'occupation_code' => $this->occupation_code,
            'education_code' => $this->education_code,
            'civil_status_code' => $this->civil_status_code,
            'consent_flag' => $this->consent_flag,
            'image_url' => $this->image_url,
            'household_folder' => $this->when($this->relationLoaded('householdFolder'), new HouseholdFolderResource($this->householdFolder)),
            'household_member' => $this->when($this->relationLoaded('householdMember'), new HouseholdMemberResource($this->householdMember)),
            'deleted_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
