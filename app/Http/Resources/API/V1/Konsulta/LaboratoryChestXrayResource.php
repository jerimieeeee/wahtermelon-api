<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryChestXrayResource extends JsonResource
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
                'pFindings' => $this->findings_code?? "",
                'pRemarksFindings' => strtoupper($this->remarks_findings?? ""),
                'pObservation' => $this->observation_code?? "",
                'pRemarksObservation' => strtoupper($this->remarks_observation?? ""),
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
