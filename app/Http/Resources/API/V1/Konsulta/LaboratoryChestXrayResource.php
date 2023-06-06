<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryChestXrayResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->chestXray->referral_facility ?? ''),
                'pLabDate' => isset($this->chestXray->laboratory_date) ? $this->chestXray->laboratory_date->format('Y-m-d') : '',
                'pFindings' => $this->chestXray->findings_code ?? '',
                'pRemarksFindings' => strtoupper($this->chestXray->remarks_findings ?? ''),
                'pObservation' => $this->chestXray->observation_code ?? '',
                'pRemarksObservation' => strtoupper($this->chestXray->remarks_observation ?? ''),
                'pDateAdded' => isset($this->chestXray->created_at) ? $this->chestXray->created_at->format('Y-m-d') : '',
                'pStatus' => isset($this->chestXray->lab_status_code) ? ($this->chestXray->lab_status_code == 'O' ? 'D' : $this->chestXray->lab_status_code) : '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
