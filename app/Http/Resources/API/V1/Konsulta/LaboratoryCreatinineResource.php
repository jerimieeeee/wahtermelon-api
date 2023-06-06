<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryCreatinineResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->creatinine->referral_facility ?? ''),
                'pLabDate' => isset($this->creatinine->laboratory_date) ? $this->creatinine->laboratory_date->format('Y-m-d') : '',
                'pFindings' => strtoupper($this->creatinine->findings ?? ''),
                'pDateAdded' => isset($this->creatinine->created_at) ? $this->creatinine->created_at->format('Y-m-d') : '',
                'pStatus' => isset($this->creatinine->lab_status_code) ? ($this->creatinine->lab_status_code == 'O' ? 'D' : $this->creatinine->lab_status_code) : '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
