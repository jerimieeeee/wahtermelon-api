<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryFecalOccultResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->fecalOccult->referral_facility?? ""),
                'pLabDate' => isset($this->fecalOccult->laboratory_date) ? $this->fecalOccult->laboratory_date->format('Y-m-d') : "",
                'pFindings' => $this->fecalOccult->findings_code?? "",
                'pDateAdded' => isset($this->fecalOccult->created_at) ? $this->fecalOccult->created_at->format('Y-m-d') : "",
                'pStatus' => $this->fecalOccult->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
