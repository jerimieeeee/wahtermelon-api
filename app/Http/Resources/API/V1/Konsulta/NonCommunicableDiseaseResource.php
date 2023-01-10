<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class NonCommunicableDiseaseResource extends JsonResource
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
                'pQid1_Yn' => $this->high_fat??  "",
                'pQid2_Yn' => $this->intake_vegetables??  "",
                'pQid3_Yn' => $this->intake_fruits??  "",
                'pQid4_Yn' => $this->physical_activity??  "",
                'pQid5_Ynx' => $this->presence_diabetes??  "",
                'pQid6_Yn' => $this->polyphagia??  "",
                'pQid7_Yn' => $this->polydipsia??  "",
                'pQid8_Yn' => $this->polyuria??  "",
                'pQid9_Yn' => $this->riskQuestionnaire->question1??  "",
                'pQid10_Yn' => $this->riskQuestionnaire->question2??  "",
                'pQid11_Yn' => $this->riskQuestionnaire->question3??  "",
                'pQid12_Yn' => $this->riskQuestionnaire->question4??  "",
                'pQid13_Yn' => $this->riskQuestionnaire->question5??  "",
                'pQid14_Yn' => $this->riskQuestionnaire->question6??  "",
                'pQid15_Yn' => $this->riskQuestionnaire->question7??  "",
                'pQid16_Yn' => $this->riskQuestionnaire->question8??  "",
                'pQid17_Abcde' => "",
                'pQid18_Yn' => $this->diabetes_medications??  "",
                'pQid19_Yn' => $this->riskScreeningGlucose->raised_blood_glucose??  "",
                'pQid19_Fbsmg' => $this->riskScreeningGlucose->fbs??  "",
                'pQid19_Fbsmmol' => "",
                'pQid19_Fbsdate' => !empty($this->riskScreeningGlucose->date_taken) ? $this->riskScreeningGlucose->date_taken?->format('Y-m-d') :  "",
                'pQid20_Yn' => $this->riskScreeningLipid->raised_blood_lipid??  "",
                'pQid20_Choleval' => $this->riskScreeningLipid->total_cholesterol??  "",
                'pQid20_Choledate' => !empty($this->riskScreeningLipid->date_taken) ? $this->riskScreeningLipid->date_taken?->format('Y-m-d') : "",
                'pQid21_Yn' => $this->riskScreeningKetones->presence_of_urine_ketone??  "",
                'pQid21_Ketonval' => $this->riskScreeningKetones->ketone??  "",
                'pQid21_Ketondate' => !empty($this->riskScreeningKetones->date_taken) ? $this->riskScreeningKetones->date_taken?->format('Y-m-d') : "",
                'pQid22_Yn' => $this->riskScreeningProtein->presence_of_urine_protein??  "",
                'pQid22_Proteinval' => $this->riskScreeningProtein->protein??  "",
                'pQid22_Proteindate' => !empty($this->riskScreeningProtein->date_taken) ? $this->riskScreeningProtein->date_taken?->format('Y-m-d') : "",
                'pQid23_Yn' => $this->riskQuestionnaire->angina_heart_attack??  "",
                'pQid24_Yn' => $this->riskQuestionnaire->stroke_tia??  "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
