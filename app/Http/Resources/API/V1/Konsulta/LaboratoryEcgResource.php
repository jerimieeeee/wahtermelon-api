<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryEcgResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->ecg->referral_facility ?? ''),
                'pLabDate' => isset($this->ecg->laboratory_date) ? $this->ecg->laboratory_date->format('Y-m-d') : '',
                'pFindings' => $this->ecg->findings_code ?? '',
                'pRemarks' => strtoupper($this->ecg->remarks ?? ''),
                'pDateAdded' => isset($this->ecg->created_at) ? $this->ecg->created_at->format('Y-m-d') : '',
                'pStatus' => $this->ecg->lab_status_code ?? '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
