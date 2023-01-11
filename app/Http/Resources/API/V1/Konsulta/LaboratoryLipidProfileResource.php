<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryLipidProfileResource extends JsonResource
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
                'pLabDate' => isset($this->lipiProfile->laboratory_date) ? $this->lipiProfile->laboratory_date->format('Y-m-d') : "",
                'pLdl' => strtoupper($this->lipiProfile->ldl?? ""),
                'pHdl' => strtoupper($this->lipiProfile->hdl?? ""),
                'pTotal' => "",
                'pCholesterol' => strtoupper($this->lipiProfile->cholesterol?? ""),
                'pTriglycerides' => strtoupper($this->lipiProfile->triglycerides?? ""),
                'pDateAdded' => isset($this->lipiProfile->created_at) ? $this->lipiProfile->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lipiProfile->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
