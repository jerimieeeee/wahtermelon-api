<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratorySputumResource extends JsonResource
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
                'pDataCollection' => $this->data_collection_code?? "",
                'pFindings' => $this->findings_code?? "",
                'pRemarks' => strtoupper($this->remarks?? ""),
                'pNoPlusses' => strtoupper($this->reading?? ""),
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
