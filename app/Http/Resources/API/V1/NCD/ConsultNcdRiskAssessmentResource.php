<?php

namespace App\Http\Resources\API\V1\NCD;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultNcdRiskAssessmentResource extends JsonResource
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
            'id' => $this->id,
            'patient_ncd_id' => $this->patient_ncd_id,
            'patient_id' => $this->patient_id,
            'consult_id' => $this->consult_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'location' => $this->location,
            'client_type' => $this->client_type,
            'assessment_date' => $this->assessment_date,
            'family_hx_hypertension' => $this->family_hx_hypertension,
            'family_hx_stroke' => $this->family_hx_stroke,
            'family_hx_heart_attack' => $this->family_hx_heart_attack,
            'family_hx_diabetes' => $this->family_hx_diabetes,
            'family_hx_asthma' => $this->family_hx_asthma,
            'family_hx_cancer' => $this->family_hx_cancer,
            'family_hx_kidney_disease' => $this->family_hx_kidney_disease,
            'smoking' => $this->smoking,
            'alcohol_intake' => $this->alcohol_intake,
            'excessive_alcohol_intake' => $this->excessive_alcohol_intake,
            'high_fat' => $this->high_fat,
            'intake_fruits' => $this->intake_fruits,
            'physical_activity' => $this->physical_activity,
            'intake_vegetables' => $this->intake_vegetables,
            'presence_diabetes' => $this->presence_diabetes,
            'diabetes_medications' => $this->diabetes_medications,
            'polyphagia' => $this->polyphagia,
            'polydipsia' => $this->polydipsia,
            'polyuria' => $this->polyuria,
            'obesity' => $this->obesity,
            'central_adiposity' => $this->central_adiposity,
            'bmi' => $this->bmi,
            'waist_line' => $this->waist_line,
            'raised_bp' => $this->raised_bp,
            'avg_systolic' => $this->avg_systolic,
            'avg_diastolic' => $this->avg_diastolic,
            'systolic_1st' => $this->systolic_1st,
            'diastolic_1st' => $this->diastolic_1st,
            'diastolic_2nd' => $this->diastolic_2nd,
            'systolic_2nd' => $this->systolic_2nd,
            'gender' => $this->gender,
            'age' => $this->age,
            'hypertensive_old_case' => $this->hypertensive_old_case,
            'diabetes_old_case' => $this->diabetes_old_case,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'riskScreeningGlucose' => $this->whenLoaded('riskScreeningGlucose'),
            'riskScreeningLipid' => $this->whenLoaded('riskScreeningLipid'),
            'riskScreeningKetones' => $this->whenLoaded('riskScreeningKetones'),
            'riskScreeningProtein' => $this->whenLoaded('riskScreeningProtein'),
            'riskQuestionnaire' => $this->whenLoaded('riskQuestionnaire'),
            'patientNcdRecord' => $this->whenLoaded('patientNcdRecord'),
            'ncdRecordDiagnosis' => $this->whenLoaded('ncdRecordDiagnosis'),
            'ncdRecordTargetOrgan' => $this->whenLoaded('ncdRecordTargetOrgan'),
            'ncdRecordCounselling' => $this->whenLoaded('ncdRecordCounselling'),
            'riskCasdt2' => $this->whenLoaded('riskCasdt2'),
            'eye_complaints' => $this->whenLoaded('riskCasdt2Vision'),
            'risk_stratification' => $this->risk_stratification,
        ];
    }
}
