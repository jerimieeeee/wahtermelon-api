<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratoryOralGlucoseResource extends JsonResource
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
                'pLabDate' => isset($this->oralGlucose->laboratory_date) ? $this->oralGlucose->laboratory_date->format('Y-m-d') : "",
                'pExamFastingMg' => strtoupper($this->oralGlucose->fasting_exam_mg?? ""),
                'pExamFastingMmol' => strtoupper($this->oralGlucose->fasting_exam_mmol?? ""),
                'pExamOgttOneHrMg' => strtoupper($this->oralGlucose->ogtt_one_hour_mg?? ""),
                'pExamOgttOneHrMmol' => strtoupper($this->oralGlucose->ogtt_one_hour_mmol?? ""),
                'pExamOgttTwoHrMg' => strtoupper($this->oralGlucose->ogtt_two_hour_mg?? ""),
                'pExamOgttTwoHrMmol' => strtoupper($this->oralGlucose->ogtt_two_hour_mmol?? ""),
                'pDateAdded' => isset($this->oralGlucose->created_at) ? $this->oralGlucose->created_at->format('Y-m-d') : "",
                'pStatus' => $this->oralGlucose->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
