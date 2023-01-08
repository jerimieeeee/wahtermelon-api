<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
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
                'pHciCaseNo' => $this->patient->case_number?? "",
                'pHciTransNo' => $this->transaction_number?? "",
                'pSoapDate' => !empty($this->consult_date) ? $this->consult_date->format('Y-m-d') : "",
                'pPatientPin' => $this->philhealthLatest->philhealth_id?? "",
                'pPatientType' => $this->philhealthLatest->membership_type_id?? "",
                'pMemPin' => !empty($this->philhealthLatest->member_pin) ? $this->philhealthLatest->member_pin : $this->philhealth_id?? "",
                'pEffYear' => $this->philhealthLatest->effectivity_year?? "",
                'pATC' => $this->atc?? "",
                'pIsWalkedIn' => !empty($this->id) ? $this->walkedin ? "Y" : "N" : "",
                'pCoPay' => "",
                'pTransDate' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
            'SUBJECTIVE' => [SubjectiveResource::make([[]])->resolve()],
            'PEPERT' => [PhysicalExaminationVitalsResource::make([[]])->resolve()],
            'PEMISCS' => [
                'PEMISC' => [PhysicalExaminationMiscResource::collection([[]])->resolve()],
            ],
            'PESPECIFIC' => [PhysicalExaminationSpecificResource::make([[]])->resolve()],
            'ICDS' => [
                'ICD' => [DiagnosisResource::collection([[]])->resolve()],
            ],
            'DIAGNOSTICS' => [
                'DIAGNOSTIC' => [DiagnosticResource::collection([[]])->resolve()],
            ],
            'MANAGEMENTS' => [
                'MANAGEMENT' => [ManagementResource::collection([[]])->resolve()],
            ],
            'ADVICE' => [AdviceResource::make([[]])->resolve()],
        ];
    }
}
