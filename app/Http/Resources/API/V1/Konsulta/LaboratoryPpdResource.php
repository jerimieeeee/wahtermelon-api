<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryPpdResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->ppd->referral_facility ?? ''),
                'pLabDate' => isset($this->ppd->laboratory_date) ? $this->ppd->laboratory_date->format('Y-m-d') : '',
                'pFindings' => strtoupper($this->ppd->findings_code ?? ''),
                'pDateAdded' => isset($this->ppd->created_at) ? $this->ppd->created_at->format('Y-m-d') : '',
                'pStatus' => $this->ppd->lab_status_code ?? '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
