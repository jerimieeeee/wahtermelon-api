<?php

namespace App\Http\Resources\API\V1\Eclaims;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EclaimsXmlCf1Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            '_attributes' => [
                'pMemberPIN' => $this->membership_type_id === 'MM' ? $this->philhealth_id : $this->member_pin,
                'pMemberLastName' => $this->membership_type_id === 'MM' ? $this->last_name : $this->member_last_name,
                'pMemberFirstName' => $this->membership_type_id === 'MM' ? $this->first_name : $this->member_first_name,
                'pMemberSuffix' => $this->membership_type_id === 'MM' ? ($this->suffix_name != 'NA' ? $this->suffix_name : '') : ($this->member_suffix_name != 'NA' ? $this->member_suffix_name : ''),
                'pMemberMiddleName' => $this->membership_type_id === 'MM' ? ($this->middle_name != '' ? $this->middle_name : 'N/A') : ($this->member_middle_name != ''  ? $this->member_middle_name : 'N/A'),
                'pMemberBirthDate' => $this->membership_type_id === 'MM' ? $this->birthdate->format('m-d-Y') : Carbon::parse($this->member_birthdate)->format('m-d-Y'),
                'pMemberShipType' => $this->philhealth_cat_id,
                'pMailingAddress' => str_replace("'", '&#39;', $this->address).' '.str_replace("'", '&#39;', $this->barangay_name).' '.str_replace("'", '&#39;', $this->municipality_name).' '.str_replace("'", '&#39;', $this->province_name),
                'pZipCode' => '2418',
                'pMemberSex' => $this->membership_type_id === 'MM' ? $this->gender : $this->member_gender,
                'pLandlineNo' => '',
                'pMobileNo' => $this->mobile_number ?? '',
                'pEmailAddress' => '',
                'pPatientIs' => $this->membership_type_id === 'MM' ? 'M' : $this->member_relation_id,
                'pPatientPIN' => $this->philhealth_id,
                'pPatientLastName' => $this->last_name,
                'pPatientFirstName' => $this->first_name,
                'pPatientSuffix' => $this->suffix_name != 'NA' ? $this->suffix_name : '',
                'pPatientMiddleName' => $this->middle_name != '' ? $this->middle_name : 'N/A',
                'pPatientBirthDate' => $this->birthdate->format('m-d-Y'),
                'pPatientSex' => $this->gender ?? '',
                'pPEN' => $this->employer_pin ?? '',
                'pEmployerName' => $this->employer_name ?? '',
            ],
        ];

        //text,'UTF-8')
    }
}
