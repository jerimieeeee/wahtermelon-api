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
            'pHciCaseNo' => $this->case_number?? "",
            'pHciTransNo' => $this->transaction_number?? "",
            'pEffYear' => $this->effectivity_year?? "",
            'pEnlistStat' => $this->enlistment_status_id?? "",
            'pEnlistDate' => $this->enlistment_date?? "",
            'pPackageType' => $this->package_type_id?? "",
            'pMemPin' => $this->member_pin?? "",
            'pMemFname' => strtoupper($this->member_first_name?? ""),
            'pMemMname' => strtoupper($this->member_middle_name?? ""),
            'pMemLname' => strtoupper($this->member_last_name?? ""),
            'pMemExtname' => strtoupper($this->member_suffix_name?? ""),
            'pMemDob' => $this->member_birthdate?? "",
            'pPatientPin' => $this->philhealth_id?? "",
            'pPatientFname' => $this->first_name?? "",
            'pPatientMname' => $this->middle_name?? "",
            'pPatientLname' => $this->last_name?? "",
            'pPatientExtname' => $this->suffix_name?? "",
            'pPatientSex' => $this->gender?? "",
            'pPatientDob' => $this->birthdate?? "",
            'pPatientType' => $this->membership_type_id?? "",
            'pPatientMobileNo' => $this->mobile_number?? "",
            'pPatientLandlineNo' => "",
            'pWithConsent' => isset($this->consent_flag) ? 'Y' : 'N',
            'pTransDate' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
            'pCreatedBy' => "TEST01",
            'pReportStatus' => "U",
            'pDeficiencyRemarks' => "",
        ];
    }
}
