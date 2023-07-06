<?php

namespace App\Http\Resources\API\V1\Eclaims;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EclaimsXmlCf1Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            '_attributes' => [
                'pMemberPin' => $this->membership_type_id === 'MM' ? $this->philhealth_id : $this->member_pin,
                'pMemberLastName' => mb_strtoupper($this->membership_type_id === 'MM' ? $this->last_name : $this->member_last_name, 'UTF-8'),
                'pMemberFirstName' => mb_strtoupper($this->membership_type_id === 'MM' ? $this->fist_name : $this->member_fist_name, 'UTF-8'),
                'pMemberSuffix' => mb_strtoupper($this->membership_type_id === 'MM' ? ($this->suffix_name != 'NA' ? $this->suffix_name : '') : ($this->member_suffix_name != 'NA' ? $this->member_suffix_name : ''), 'UTF-8'),
                'pMemberMiddleName' => mb_strtoupper($this->membership_type_id === 'MM' ? ($this->middle_name ?? '') : ($this->member_middle_name ?? ''), 'UTF-8'),
                'pMemberBirthDate' => $this->membership_type_id === 'MM' ? $this->birthdate->format('Y-m-d') : $this->member_birthdate->format('Y-m-d'),
                'pMemberShipType' => $this->philhealth_cat_id,
                'pMailingAddress' => mb_strtoupper(str_replace("'","&#39;", $this->address)." ".str_replace("'","&#39;", $this->barangay_name)." ".str_replace("'","&#39;", $this->municipality_name)." ".str_replace("'","&#39;", $this->province_name), 'UTF-8'),
                'pZipCode' => '2418',
                'pMemberSex' => $this->membership_type_id === 'MM' ? $this->gender : $this->member_gender,
                'pLandlineNo' => '',
                'pMobileNo' => $this->mobile_number ?? '',
                'pEmailAddress' => '',
                'pPatientIs' => $this->membership_type_id === 'MM' ? 'M' : $this->member_relation_id,
                'pPatientPIN' => $this->philhealth_id,
                'pPatientLastName' => mb_strtoupper($this->last_name, 'UTF-8'),
                'pPatientFirstName' => mb_strtoupper($this->fist_name, 'UTF-8'),
                'pPatientSuffix' => mb_strtoupper($this->suffix_name != 'NA' ? $this->suffix_name : '', 'UTF-8'),
                'pPatientMiddleName' => mb_strtoupper($this->middle_name ?? '', 'UTF-8'),
                'pPatientBirthDate' => $this->birthdate->format('Y-m-d'),
                'pPatientSex' => $this->gender ?? '',
                'pPEN' => $this->employer_pin ?? '',
                'pEmployerName' => $this->employer_name ?? '',
            ]
        ];
    }
}
