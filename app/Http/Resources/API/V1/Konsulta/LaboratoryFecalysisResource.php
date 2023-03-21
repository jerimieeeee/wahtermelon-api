<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryFecalysisResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->fecalysis->referral_facility?? ""),
                'pLabDate' => isset($this->fecalysis->laboratory_date) ? $this->fecalysis->laboratory_date->format('Y-m-d') : "",
                'pColor' =>strtoupper($this->fecalysis->color_code?? ""),
                'pConsistency' => strtoupper($this->fecalysis->consistency_code?? ""),
                'pRbc' => strtoupper($this->fecalysis->rbc?? ""),
                'pWbc' => strtoupper($this->fecalysis->wbc?? ""),
                'pOva' => strtoupper($this->fecalysis->ova?? ""),
                'pParasite' => strtoupper($this->fecalysis->parasite?? ""),
                'pBlood' => strtoupper($this->fecalysis->blood_code?? ""),
                'pPusCells' => strtoupper($this->fecalysis->pus_cells?? ""),
                'pDateAdded' => isset($this->fecalysis->created_at) ? $this->fecalysis->created_at->format('Y-m-d') : "",
                'pStatus' => $this->fecalysis->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
