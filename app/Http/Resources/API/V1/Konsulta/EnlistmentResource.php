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
                'pHciCaseNo' => $this->case_number ?? '',
                'pHciTransNo' => ! empty($this->transaction_number) ? 'E'.$this->transaction_number : '',
                'pEffYear' => $this->effectivity_year ?? '',
                'pEnlistStat' => $this->enlistment_status_id ?? '',
                'pEnlistDate' => $this->enlistment_date ?? '',
                'pPackageType' => $this->package_type_id ?? '',
                'pMemPin' => ! empty($this->member_pin) ? $this->member_pin : $this->philhealth_id ?? '',
                'pMemFname' => mb_strtoupper(! empty($this->member_first_name) ? $this->member_first_name : $this->first_name ?? '', 'UTF-8'),
                'pMemMname' => mb_strtoupper(! empty($this->member_middle_name) ? $this->member_middle_name : $this->middle_name ?? '', 'UTF-8'),
                'pMemLname' => mb_strtoupper(! empty($this->member_last_name) ? $this->member_last_name : $this->last_name ?? '', 'UTF-8'),
                //'pMemExtname' => mb_strtoupper(! empty($this->member_suffix_name) && $this->member_suffix_name != 'NA' ? ($this->member_suffix_name == 'JR' || $this->member_suffix_name == 'SR' ? $this->member_suffix_name . '.' : $this->member_suffix_name) : (! empty($this->suffix_name) && $this->suffix_name != 'NA' ? ($this->suffix_name == 'JR' || $this->suffix_name == 'SR' ? $this->suffix_name . '.' : $this->suffix_name) : ''), 'UTF-8'),
                'pMemExtname' => mb_strtoupper($this->konsulta_member_suffix_name ?? '', 'UTF-8'),
                'pMemDob' => ! empty($this->member_birthdate) ? $this->member_birthdate : $this->birthdate ?? '',
                'pPatientPin' => $this->philhealth_id ?? '',
                'pPatientFname' => mb_strtoupper($this->first_name ?? '', 'UTF-8'),
                'pPatientMname' => mb_strtoupper($this->middle_name ?? '', 'UTF-8'),
                'pPatientLname' => mb_strtoupper($this->last_name ?? '', 'UTF-8'),
                //'pPatientExtname' => mb_strtoupper(! empty($this->suffix_name) && $this->suffix_name != 'NA' ? ($this->suffix_name == 'JR' || $this->suffix_name == 'SR' ? $this->suffix_name . '.' : $this->suffix_name) : '', 'UTF-8'),
                'pPatientExtname' => mb_strtoupper($this->patient_suffix_name ?? '', 'UTF-8'),
                'pPatientSex' => $this->gender ?? '',
                'pPatientDob' => $this->birthdate ?? '',
                'pPatientType' => $this->membership_type_id ?? '',
                'pPatientMobileNo' => $this->mobile_number ?? '',
                'pPatientLandlineNo' => '',
                'pWithConsent' => isset($this->consent_flag) ? 'Y' : 'N',
                'pTransDate' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : '',
                'pCreatedBy' => mb_strtoupper($this->created_by ?? '', 'UTF-8'),
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
