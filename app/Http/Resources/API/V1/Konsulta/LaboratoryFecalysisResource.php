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
                'pReferralFacility' => "",
                'pLabDate' => isset($this->fecalysis->laboratory_date) ? $this->fecalysis->laboratory_date->format('Y-m-d') : "",
                'pColor' => $this->fecalysis->color_code?? "",
                'pConsistency' => $this->fecalysis->consistency_code?? "",
                'pRbc' => $this->fecalysis->rbc?? "",
                'pWbc' => $this->fecalysis->wbc?? "",
                'pOva' => $this->fecalysis->ova?? "",
                'pParasite' => $this->fecalysis->parasite?? "",
                'pBlood' => $this->fecalysis->blood_code?? "",
                'pPusCells' => $this->fecalysis->pus_cells?? "",
                'pDateAdded' => isset($this->fecalysis->created_at) ? $this->fecalysis->created_at->format('Y-m-d') : "",
                'pStatus' => $this->fecalysis->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
