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
                'pLabDate' => isset($this->urinalysis->laboratory_date) ? $this->urinalysis->laboratory_date->format('Y-m-d') : "",
                'pGravity' => $this->urinalysis->gravity?? "",
                'pAppearance' => $this->urinalysis->appearance?? "",
                'pColor' => $this->urinalysis->color?? "",
                'pGlucose' => $this->urinalysis->glucose?? "",
                'pProteins' => $this->urinalysis->proteins?? "",
                'pKetones' => $this->urinalysis->ketones?? "",
                'pPh' => $this->urinalysis->ph?? "",
                'pRbCells' => $this->urinalysis->rb_cells?? "",
                'pWbCells' =>  $this->urinalysis->wb_cells?? "",
                'pBacteria' => $this->urinalysis->bacteria?? "",
                'pCrystals' => $this->urinalysis->crystals?? "",
                'pBladderCell' => $this->urinalysis->bladder_cells?? "",
                'pSquamousCell' => $this->urinalysis->squamous_cells?? "",
                'pTubularCell' => $this->urinalysis->tubular_cells?? "",
                'pBroadCasts' => $this->urinalysis->broad_cast?? "",
                'pEpithelialCast' => $this->urinalysis->epithelial_cast?? "",
                'pGranularCast' =>  $this->urinalysis->granular_cast?? "",
                'pHyalineCast' => $this->urinalysis->hyaline_cast?? "",
                'pRbcCast' => $this->urinalysis->rbc_cast?? "",
                'pWaxyCast' => $this->urinalysis->waxy_cast?? "",
                'pWcCast' => $this->urinalysis->wc_cast?? "",
                'pAlbumin' => $this->urinalysis->albumin?? "",
                'pPusCells' => $this->urinalysis->pus_cells?? "",
                'pDateAdded' => isset($this->urinalysis->created_at) ? $this->urinalysis->created_at->format('Y-m-d') : "",
                'pStatus' => $this->urinalysis->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
