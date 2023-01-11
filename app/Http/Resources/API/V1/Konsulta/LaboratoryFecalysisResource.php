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
                'pLabDate' => isset($this->laboratory_date) ? $this->laboratory_date->format('Y-m-d') : "",
                'pColor' => $this->color_code?? "",
                'pConsistency' => $this->consistency_code?? "",
                'pRbc' => $this->rbc?? "",
                'pWbc' => $this->wbc?? "",
                'pOva' => $this->ova?? "",
                'pParasite' => $this->parasite?? "",
                'pBlood' => $this->blood_code?? "",
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
