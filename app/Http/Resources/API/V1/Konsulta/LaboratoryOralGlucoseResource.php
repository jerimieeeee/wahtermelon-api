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
                'pLabDate' => $this->laboratory_date?? "",
                'pExamFastingMg' => $this->fasting_exam_mg?? "",
                'pExamFastingMmol' => $this->fasting_exam_mmol?? "",
                'pExamOgttOneHrMg' => $this->ogtt_one_hour_mg?? "",
                'pExamOgttOneHrMmol' => $this->ogtt_one_hour_mmol?? "",
                'pExamOgttTwoHrMg' => $this->ogtt_two_hour_mg?? "",
                'pExamOgttTwoHrMmol' => $this->ogtt_two_hour_mmol?? "",
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pStatus' => $this->lab_status_code?? "",
                'pDiagnosticLabFee' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
        ];
    }
}
