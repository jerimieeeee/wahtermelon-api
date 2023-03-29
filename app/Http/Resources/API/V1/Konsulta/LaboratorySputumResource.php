<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratorySputumResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->sputum->referral_facility ?? ''),
                'pLabDate' => isset($this->sputum->laboratory_date) ? $this->sputum->laboratory_date->format('Y-m-d') : '',
                'pDataCollection' => $this->sputum->data_collection_code ?? '',
                'pFindings' => $this->sputum->findings_code ?? '',
                'pRemarks' => strtoupper($this->sputum->remarks ?? ''),
                'pNoPlusses' => strtoupper($this->sputum->reading ?? ''),
                'pDateAdded' => isset($this->sputum->created_at) ? $this->sputum->created_at->format('Y-m-d') : '',
                'pStatus' => $this->sputum->lab_status_code ?? '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
