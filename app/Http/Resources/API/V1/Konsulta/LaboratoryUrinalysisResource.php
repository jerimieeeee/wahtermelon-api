<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryUrinalysisResource extends JsonResource
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
                'pGravity' => $this->gravity?? "",
                'pAppearance' => $this->appearance?? "",
                'pColor' => $this->appearance?? "",
                'pGlucose' => $this->mch?? "",
                'pRbCells' => $this->mch?? "",
                'pWbCells' =>  $this->mch?? "",
                'pBacteria' => $this->mch?? "",
                'pCrystals' => $this->mch?? "",
                'pBladderCell' => $this->mcv?? "",
                'pSquamousCell' => $this->wbc?? "",
                'pTubularCell' => "",
                'pBroadCasts' => "",
                'pEpithelialCast' => $this->neutrophils?? "",
                'pGranularCast' =>  "",
                'pHyalineCast' => $this->lymphocytes?? "",
                'pRbcCast' => $this->monocytes?? "",
                'pWaxyCast' => $this->eosinophils?? "",
                'pWcCast' => $this->basophils?? "",
                'pAlbumin' => $this->platelets?? "",
                'pPusCells' => $this->platelets?? "",
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
