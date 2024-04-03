<?php

namespace App\Http\Resources\API\V1\Konsulta;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
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
        if (! empty($this->id)) {
            $totalCholesterol = 0;
            $age = 40;
            if ($this->location == 2) {
                $totalCholesterol = round($this->riskScreeningLipid->total_cholesterol ?? 0);
                if ($totalCholesterol > 8) {
                    $totalCholesterol = 8;
                } elseif ($totalCholesterol > 0 && $totalCholesterol <= 4) {
                    $totalCholesterol = 4;
                }
            }
            if ($this->smoking = 1) {
                $smoking = 0;
                if ($this->smoking = 2) {
                    $smoking = 0;
                } elseif ($this->smoking = 3 && $this->smoking = 4) {
                    $smoking = 1;
                }
            }
            if ($this->presence_diabetes = 'N') {
                $presence_diabetes = 0;
                if ($this->presence_diabetes = 'Y') {
                    $presence_diabetes = 1;
                } elseif ($this->smoking = 'X') {
                    $presence_diabetes = 0;
                }
            }
            if ($this->age >= 20 && $this->age <= 49) {
                $age = 40;
                if ($this->age >= 50 && $this->age <= 59) {
                    $age = 50;
                } elseif ($this->age >= 60 && $this->age <= 69) {
                    $age = 60;
                } elseif ($this->age >= 70) {
                    $age = 70;
                }
            }
            if ($this->avg_systolic <= 139) {
                $sbp = 120;
            } elseif ($this->avg_systolic >= 140 && $this->avg_systolic <= 159) {
                $sbp = 140;
            } elseif ($this->avg_systolic >= 160 && $this->avg_systolic <= 179) {
                $sbp = 160;
            } elseif ($this->avg_systolic >= 180) {
                $sbp = 180;
            } else {
                $sbp = 'N/A';
            }
            if ($this->location == 2) {
                $location = 'facility';
            } else {
                $location = 'community';
            }
            $riskStrat = LibNcdRiskStratificationChart::query()
                ->join('lib_ncd_risk_stratifications', 'lib_ncd_risk_stratifications.risk_color', '=', 'lib_ncd_risk_stratification_charts.color')
                ->where('type', '=', $location)
                ->where('diabetes_present', $presence_diabetes)
                ->where('sbp', '=', $sbp)
                ->where('age', '=', $age)
                ->where('smoking_status', '=', $smoking)
                ->where('gender', '=', $this->gender)
                ->where('cholesterol', '=', $totalCholesterol)
                ->first();
        }

        return [
            '_attributes' => [
                'pQid1_Yn' => $this->high_fat ?? '',
                'pQid2_Yn' => $this->intake_vegetables ?? '',
                'pQid3_Yn' => $this->intake_fruits ?? '',
                'pQid4_Yn' => $this->physical_activity ?? '',
                'pQid5_Ynx' => $this->presence_diabetes ?? '',
                'pQid6_Yn' => $this->polyphagia ?? '',
                'pQid7_Yn' => $this->polydipsia ?? '',
                'pQid8_Yn' => $this->polyuria ?? '',
                'pQid9_Yn' => $this->riskQuestionnaire->question1 ?? '',
                'pQid10_Yn' => $this->riskQuestionnaire->question2 ?? '',
                'pQid11_Yn' => $this->riskQuestionnaire->question3 ?? '',
                'pQid12_Yn' => $this->riskQuestionnaire->question4 ?? '',
                'pQid13_Yn' => $this->riskQuestionnaire->question5 ?? '',
                'pQid14_Yn' => $this->riskQuestionnaire->question6 ?? '',
                'pQid15_Yn' => $this->riskQuestionnaire->question7 ?? '',
                'pQid16_Yn' => $this->riskQuestionnaire->question8 ?? '',
                'pQid17_Abcde' => $riskStrat->konsulta_risk_stratifcation_id ?? '',
                'pQid18_Yn' => $this->diabetes_medications ?? '',
                'pQid19_Yn' => !empty($this->riskScreeningGlucose->raised_blood_glucose) ? ($this->riskScreeningGlucose->raised_blood_glucose == 1 ? 'Y' : ($this->riskScreeningGlucose->raised_blood_glucose == 0 ? 'N' : '')) : '',
                'pQid19_Fbsmg' => $this->riskScreeningGlucose->fbs ?? '',
                'pQid19_Fbsmmol' => '',
                'pQid19_Fbsdate' => ! empty($this->riskScreeningGlucose->date_taken) ? $this->riskScreeningGlucose->date_taken?->format('Y-m-d') : '',
                'pQid20_Yn' => !empty($this->riskScreeningLipid->raised_blood_lipid) ? ($this->riskScreeningLipid->raised_blood_lipid == 1 ? 'Y' : ($this->riskScreeningLipid->raised_blood_lipid == 0 ? 'N' : '')) : '',
                'pQid20_Choleval' => $this->riskScreeningLipid->total_cholesterol ?? '',
                'pQid20_Choledate' => ! empty($this->riskScreeningLipid->date_taken) ? $this->riskScreeningLipid->date_taken?->format('Y-m-d') : '',
                'pQid21_Yn' => !empty($this->riskScreeningKetones->presence_of_urine_ketone) ? ($this->riskScreeningKetones->presence_of_urine_ketone == 1 ? 'Y' : ($this->riskScreeningKetones->presence_of_urine_ketone == 0 ? 'N' : '')) : '',
                'pQid21_Ketonval' => $this->riskScreeningKetones->ketone ?? '',
                'pQid21_Ketondate' => ! empty($this->riskScreeningKetones->date_taken) ? $this->riskScreeningKetones->date_taken?->format('Y-m-d') : '',
                'pQid22_Yn' => !empty($this->riskScreeningProtein->presence_of_urine_protein) ? ($this->riskScreeningProtein->presence_of_urine_protein == 1 ? 'Y' : ($this->riskScreeningProtein->presence_of_urine_protein == 0 ? 'N' : '')) : '',
                'pQid22_Proteinval' => $this->riskScreeningProtein->protein ?? '',
                'pQid22_Proteindate' => ! empty($this->riskScreeningProtein->date_taken) ? $this->riskScreeningProtein->date_taken?->format('Y-m-d') : '',
                'pQid23_Yn' => $this->riskQuestionnaire->angina_heart_attack ?? '',
                'pQid24_Yn' => $this->riskQuestionnaire->stroke_tia ?? '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
