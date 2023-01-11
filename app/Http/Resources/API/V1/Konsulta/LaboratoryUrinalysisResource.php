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
                'pLabDate' => isset($this->laboratory_date) ? $this->laboratory_date->format('Y-m-d') : "",
                'pGravity' => $this->gravity?? "",
                'pAppearance' => $this->appearance?? "",
                'pColor' => $this->color?? "",
                'pGlucose' => $this->glucose?? "",
                'pProteins' => $this->proteins?? "",
                'pKetones' => $this->ketones?? "",
                'pPh' => $this->ph?? "",
                'pRbCells' => $this->rb_cells?? "",
                'pWbCells' =>  $this->wb_cells?? "",
                'pBacteria' => $this->bacteria?? "",
                'pCrystals' => $this->crystals?? "",
                'pBladderCell' => $this->bladder_cells?? "",
                'pSquamousCell' => $this->squamous_cells?? "",
                'pTubularCell' => $this->tubular_cells?? "",
                'pBroadCasts' => $this->broad_cast?? "",
                'pEpithelialCast' => $this->epithelial_cast?? "",
                'pGranularCast' =>  $this->granular_cast?? "",
                'pHyalineCast' => $this->hyaline_cast?? "",
                'pRbcCast' => $this->rbc_cast?? "",
                'pWaxyCast' => $this->waxy_cast?? "",
                'pWcCast' => $this->wc_cast?? "",
                'pAlbumin' => $this->albumin?? "",
                'pPusCells' => $this->pus_cells?? "",
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
