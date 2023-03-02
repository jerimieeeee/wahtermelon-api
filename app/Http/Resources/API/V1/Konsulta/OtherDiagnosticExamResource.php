<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class OtherDiagnosticExamResource extends JsonResource
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
            '_attributes'  => [
                'pReferralFacility' => strtoupper($this->getRelatedModel('gramStain')->referral_facility?? ""),
                'pLabDate' => isset($this->getRelatedModel('gramStain')->laboratory_date) ? $this->getRelatedModel('gramStain')->laboratory_date->format('Y-m-d') : "",
                'pOthDiagExam' => strtoupper($this->laboratory->desc?? ""),
                'pFindings' => strtoupper($this->getRelatedModel('gramStain')->remarks?? ""),
                'pDateAdded' => isset($this->getRelatedModel('gramStain')->created_at) ? $this->getRelatedModel('gramStain')->created_at->format('Y-m-d') : "",
                'pStatus' => $this->getRelatedModel('gramStain')->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => "",
            ]
        ];
    }
}
