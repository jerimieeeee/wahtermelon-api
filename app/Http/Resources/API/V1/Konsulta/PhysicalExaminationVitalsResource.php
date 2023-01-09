<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalExaminationVitalsResource extends JsonResource
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
                'pSystolic' => $this->bp_systolic?? "",
                'pDiastolic' => $this->bp_diastolic?? "",
                'pHr' => !empty($this->patient_heart_rate) ? number_format($this->patient_heart_rate) : "",
                'pRr' => !empty($this->patient_respiratory_rate) ? number_format($this->patient_respiratory_rate) : "",
                'pTemp' => $this->patient_temp?? "",
                'pHeight' => $this->patient_height?? "",
                'pWeight' => $this->patient_weight?? "",
                'pBMI' => $this->patient_bmi?? "",
                'pZScore' => "",
                'pLeftVision' => "",
                'pRightVision' => "",
                'pLength' => $this->patient_height?? "",
                'pHeadCirc' => $this->patient_head_circumference?? "",
                'pSkinfoldThickness' => $this->patient_skinfold_thickness?? "",
                'pWaist' => $this->patient_waist?? "",
                'pHip' => $this->patient_hip?? "",
                'pLimbs' => $this->patient_limbs?? "",
                'pMidUpperArmCirc' => $this->patient_muac?? "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
