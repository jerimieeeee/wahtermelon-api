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
                'pLabDate' => $this->laboratory_date?? "",
                'pLdl' => $this->ldl?? "",
                'pHdl' => $this->hdl?? "",
                'pTotal' => "",
                'pCholesterol' => $this->cholesterol?? "",
                'pTriglycerides' => $this->triglycerides?? "",
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
