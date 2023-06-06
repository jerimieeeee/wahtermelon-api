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
                'pReferralFacility' => strtoupper($this->urinalysis->referral_facility ?? ''),
                'pLabDate' => isset($this->urinalysis->laboratory_date) ? $this->urinalysis->laboratory_date->format('Y-m-d') : '',
                'pGravity' => strtoupper($this->urinalysis->gravity ?? ''),
                'pAppearance' => strtoupper($this->urinalysis->appearance ?? ''),
                'pColor' => strtoupper($this->urinalysis->color ?? ''),
                'pGlucose' => strtoupper($this->urinalysis->glucose ?? ''),
                'pProteins' => strtoupper($this->urinalysis->proteins ?? ''),
                'pKetones' => strtoupper($this->urinalysis->ketones ?? ''),
                'pPh' => strtoupper($this->urinalysis->ph ?? ''),
                'pRbCells' => strtoupper($this->urinalysis->rb_cells ?? ''),
                'pWbCells' => strtoupper($this->urinalysis->wb_cells ?? ''),
                'pBacteria' => strtoupper($this->urinalysis->bacteria ?? ''),
                'pCrystals' => strtoupper($this->urinalysis->crystals ?? ''),
                'pBladderCell' => strtoupper($this->urinalysis->bladder_cells ?? ''),
                'pSquamousCell' => strtoupper($this->urinalysis->squamous_cells ?? ''),
                'pTubularCell' => strtoupper($this->urinalysis->tubular_cells ?? ''),
                'pBroadCasts' => strtoupper($this->urinalysis->broad_cast ?? ''),
                'pEpithelialCast' => strtoupper($this->urinalysis->epithelial_cast ?? ''),
                'pGranularCast' => strtoupper($this->urinalysis->granular_cast ?? ''),
                'pHyalineCast' => strtoupper($this->urinalysis->hyaline_cast ?? ''),
                'pRbcCast' => strtoupper($this->urinalysis->rbc_cast ?? ''),
                'pWaxyCast' => strtoupper($this->urinalysis->waxy_cast ?? ''),
                'pWcCast' => strtoupper($this->urinalysis->wc_cast ?? ''),
                'pAlbumin' => strtoupper($this->urinalysis->albumin ?? ''),
                'pPusCells' => strtoupper($this->urinalysis->pus_cells ?? ''),
                'pDateAdded' => isset($this->urinalysis->created_at) ? $this->urinalysis->created_at->format('Y-m-d') : '',
                'pStatus' => isset($this->urinalysis->lab_status_code) ? ($this->urinalysis->lab_status_code == 'O' ? 'D' : $this->urinalysis->lab_status_code) : '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
