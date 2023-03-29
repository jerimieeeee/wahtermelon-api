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
            '_attributes' => [
                'pReferralFacility' => strtoupper($this->getRelatedModel($this->lab)->referral_facility ?? ''),
                'pLabDate' => isset($this->getRelatedModel($this->lab)->laboratory_date) ? $this->getRelatedModel($this->lab)->laboratory_date->format('Y-m-d') : '',
                'pOthDiagExam' => strtoupper($this->laboratory->desc ?? ''),
                'pFindings' => strtoupper($this->getRelatedModel($this->lab)->remarks ?? ''),
                'pDateAdded' => isset($this->getRelatedModel($this->lab)->created_at) ? $this->getRelatedModel($this->lab)->created_at->format('Y-m-d') : '',
                'pStatus' => $this->getRelatedModel($this->lab)->lab_status_code ?? '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
