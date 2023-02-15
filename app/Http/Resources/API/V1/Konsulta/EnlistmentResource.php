<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class EnlistmentResource extends JsonResource
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
            '_attributes' => [
                'pHciCaseNo' => $this->case_number?? "",
                'pHciTransNo' => !empty($this->transaction_number) ? 'E'.$this->transaction_number : "",
                'pEffYear' => $this->effectivity_year?? "",
                'pEnlistStat' => $this->enlistment_status_id?? "",
                'pEnlistDate' => $this->enlistment_date?? "",
                'pPackageType' => $this->package_type_id?? "",
                'pMemPin' => !empty($this->member_pin) ? $this->member_pin : $this->philhealth_id?? "",
                'pMemFname' => strtoupper(!empty($this->member_first_name) ? $this->member_first_name : $this->first_name?? ""),
                'pMemMname' => strtoupper(!empty($this->member_middle_name) ? $this->member_middle_name : $this->middle_name?? ""),
                'pMemLname' => strtoupper(!empty($this->member_last_name) ? $this->member_last_name : $this->last_name?? ""),
                'pMemExtname' => strtoupper(!empty($this->member_suffix_name) && $this->member_suffix_name != 'NA' ? $this->member_suffix_name : (!empty($this->suffix_name) && $this->suffix_name != 'NA' ? $this->suffix_name : "")),
                'pMemDob' => !empty($this->member_birthdate) ? $this->member_birthdate : $this->birthdate?? "",
                'pPatientPin' => $this->philhealth_id?? "",
                'pPatientFname' => strtoupper($this->first_name?? ""),
                'pPatientMname' => strtoupper($this->middle_name?? ""),
                'pPatientLname' => strtoupper($this->last_name?? ""),
                'pPatientExtname' => strtoupper(!empty($this->suffix_name) && $this->suffix_name != 'NA' ? $this->suffix_name : ""),
                'pPatientSex' => $this->gender?? "",
                'pPatientDob' => $this->birthdate?? "",
                'pPatientType' => $this->membership_type_id?? "",
                'pPatientMobileNo' => $this->mobile_number?? "",
                'pPatientLandlineNo' => "",
                'pWithConsent' => isset($this->consent_flag) ? 'Y' : 'N',
                'pTransDate' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pCreatedBy' => strtoupper($this->created_by?? ""),
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => "",
            ]
        ];
    }
}
