<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryCbcResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->cbc->referral_facility ?? ''),
                'pLabDate' => isset($this->cbc->laboratory_date) ? $this->cbc->laboratory_date->format('Y-m-d') : '',
                'pHematocrit' => $this->cbc->hematocrit ?? '',
                'pHemoglobinG' => $this->cbc->hemoglobin ?? '',
                'pHemoglobinMmol' => '',
                'pMhcPg' => $this->cbc->mch ?? '',
                'pMhcFmol' => '',
                'pMchcGhb' => '',
                'pMchcMmol' => '',
                'pMcvUm' => '',
                'pMcvFl' => $this->cbc->mcv ?? '',
                'pWbc1000' => $this->cbc->wbc ?? '',
                'pWbc10' => '',
                'pMyelocyte' => '',
                'pNeutrophilsBnd' => $this->cbc->neutrophils ?? '',
                'pNeutrophilsSeg' => '',
                'pLymphocytes' => $this->cbc->lymphocytes ?? '',
                'pMonocytes' => $this->cbc->monocytes ?? '',
                'pEosinophils' => $this->cbc->eosinophils ?? '',
                'pBasophils' => $this->cbc->basophils ?? '',
                'pPlatelet' => $this->cbc->platelets ?? '',
                'pDateAdded' => isset($this->cbc->created_at) ? $this->cbc->created_at->format('Y-m-d') : '',
                'pStatus' => $this->cbc->lab_status_code ?? '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
