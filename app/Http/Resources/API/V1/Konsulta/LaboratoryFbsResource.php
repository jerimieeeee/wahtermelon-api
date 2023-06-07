<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryFbsResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->fbs->referral_facility ?? ''),
                'pLabDate' => isset($this->fbs->laboratory_date) ? $this->fbs->laboratory_date->format('Y-m-d') : '',
                'pGlucoseMg' => $this->fbs->glucose ?? '',
                'pGlucoseMmol' => '',
                'pDateAdded' => isset($this->fbs->created_at) ? $this->fbs->created_at->format('Y-m-d') : '',
                'pStatus' => isset($this->fbs->lab_status_code) ? ($this->fbs->lab_status_code == 'O' ? 'D' : $this->fbs->lab_status_code) : '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
