<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryHba1cResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->hba1c->referral_facility ?? ''),
                'pLabDate' => isset($this->hba1c->laboratory_date) ? $this->hba1c->laboratory_date->format('Y-m-d') : '',
                'pFindings' => strtoupper($this->hba1c->findings_code ?? ''),
                'pDateAdded' => isset($this->hba1c->created_at) ? $this->hba1c->created_at->format('Y-m-d') : '',
                'pStatus' => $this->hba1c->lab_status_code ?? '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
