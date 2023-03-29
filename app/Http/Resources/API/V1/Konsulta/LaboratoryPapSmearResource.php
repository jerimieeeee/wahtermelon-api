<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryPapSmearResource extends JsonResource
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
                'pReferralFacility' => strtoupper($this->papsmear->referral_facility ?? ''),
                'pLabDate' => isset($this->papsmear->laboratory_date) ? $this->papsmear->laboratory_date->format('Y-m-d') : '',
                'pFindings' => strtoupper($this->papsmear->findings ?? ''),
                'pImpression' => strtoupper($this->papsmear->impression ?? ''),
                'pDateAdded' => isset($this->papsmear->created_at) ? $this->papsmear->created_at->format('Y-m-d') : '',
                'pStatus' => $this->papsmear->lab_status_code ?? '',
                'pDiagnosticLabFee' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
