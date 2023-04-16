<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryRbsResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->rbs->referral_facility ?? ''),
                'pLabDate' => isset($this->rbs->laboratory_date) ? $this->rbs->laboratory_date->format('Y-m-d') : '',
                'pGlucoseMg' => strtoupper($this->rbs->glucose ?? ''),
                'pGlucoseMmol' => '',
                'pDateAdded' => isset($this->rbs->created_at) ? $this->rbs->created_at->format('Y-m-d') : '',
                'pStatus' => strtoupper($this->rbs->lab_status_code ?? ''),
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
