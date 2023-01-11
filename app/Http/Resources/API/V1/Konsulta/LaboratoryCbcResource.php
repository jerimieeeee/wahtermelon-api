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
                'pReferralFacility' => "",
                'pLabDate' => $this->laboratory_date?? "",
                'pHematocrit' => $this->hematocrit?? "",
                'pHemoglobinG' => $this->hemoglobin?? "",
                'pHemoglobinMmol' => "",
                'pMhcPg' => $this->mch?? "",
                'pMhcFmol' => "",
                'pMchcGhb' =>  "",
                'pMchcMmol' => "",
                'pMcvUm' => "",
                'pMcvFl' => $this->mcv?? "",
                'pWbc1000' => $this->wbc?? "",
                'pWbc10' => "",
                'pMyelocyte' => "",
                'pNeutrophilsBnd' => $this->neutrophils?? "",
                'pNeutrophilsSeg' =>  "",
                'pLymphocytes' => $this->lymphocytes?? "",
                'pMonocytes' => $this->monocytes?? "",
                'pEosinophils' => $this->eosinophils?? "",
                'pBasophils' => $this->basophils?? "",
                'pPlatelet' => $this->platelets?? "",
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
