<?php

namespace App\Http\Resources\API\V1\Patient;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientPhilhealthResource extends JsonResource
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
            'transaction_number' => $this->transaction_number,
            'transmittal_number' => $this->transmittal_number,
            'philhealth_id' => $this->philhealth_id,
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(!$this->relationLoaded('patient'),$this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'konsulta_registration' => $this->whenLoaded('konsultaRegistration'),
            'enlistment_date' => $this->enlistment_date,
            'effectivity_year' => $this->effectivity_year,
            'enlistment_status_id' => $this->when(!$this->relationLoaded('enlistmentStatus'),$this->enlistment_status_id),
            'enlistment_status' => $this->whenLoaded('enlistmentStatus'),
            'package_type_id' => $this->when(!$this->relationLoaded('packageType'),$this->package_type_id),
            'package_type' => $this->whenLoaded('packageType'),
            'membership_type_id' => $this->when(!$this->relationLoaded('membershipType'),$this->membership_type_id),
            'membership_type' => $this->whenLoaded('membershipType'),
            'membership_category_id' => $this->when(!$this->relationLoaded('membershipCategory'),$this->membership_category_id),
            'membership_category' => $this->whenLoaded('membershipCategory'),
            'member_pin' => $this->member_pin,
            'member_last_name' => $this->member_last_name,
            'member_first_name' => $this->member_first_name,
            'member_middle_name' => $this->member_middle_name,
            'member_suffix_name' => $this->when(!$this->relationLoaded('memberSuffixName'),$this->member_suffix_name),
            'member_suffix' => $this->whenLoaded('memberSuffixName'),
            'member_birthdate' => $this->member_birthdate,
            'member_gender' => $this->member_gender,
            'member_relation_id' => $this->when(!$this->relationLoaded('memberRelation'),$this->member_relation_id),
            'member_relation' => $this->whenLoaded('memberRelation'),
            'employer_pin' => $this->employer_pin,
            'employer_name' => $this->employer_name,
            'employer_address' => $this->employer_address,
            'authorization_transaction_code' => $this->authorization_transaction_code,
            'walkedin_status' => $this->walkedin_status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
