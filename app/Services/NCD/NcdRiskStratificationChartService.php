<?php

namespace App\Services\NCD;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;

class NcdRiskStratificationChartService
{
    /**
     * @return mixed
     */
    public function getRiskStratificationChart($request)
    {
        $consultNcdRiskAssessment = ConsultNcdRiskAssessment::where('patient_id', $request->patient_id)->first();

        if (! empty($consultNcdRiskAssessment->id)) {
            $totalCholesterol = 0;
            $age = 40;
            if ($consultNcdRiskAssessment->location == 2) {
                $totalCholesterol = round($consultNcdRiskAssessment->riskScreeningLipid->total_cholesterol ?? 0);
                if ($totalCholesterol > 8) {
                    $totalCholesterol = 8;
                } elseif ($totalCholesterol > 0 && $totalCholesterol <= 4) {
                    $totalCholesterol = 4;
                }
            }

            if ($consultNcdRiskAssessment->smoking == 1) {
                $smoking = 0;
            } elseif ($consultNcdRiskAssessment->smoking == 2) {
                $smoking = 0;
            } elseif ($consultNcdRiskAssessment->smoking == 3) {
                $smoking = 1;
            } elseif ($consultNcdRiskAssessment->smoking == 4) {
                $smoking = 1;
            } elseif ($consultNcdRiskAssessment->smoking == 5) {
                $smoking = 1;
            }

            if ($consultNcdRiskAssessment->presence_diabetes == 'Y') {
                $presence_diabetes = 1;
            } elseif ($consultNcdRiskAssessment->presence_diabetes == 'N') {
                $presence_diabetes = 0;
            } elseif ($consultNcdRiskAssessment->presence_diabetes == 'X') {
                $presence_diabetes = 0;
            }

            if ($consultNcdRiskAssessment->age >= 20 && $consultNcdRiskAssessment->age <= 49) {
                $age = 40;
            } elseif ($consultNcdRiskAssessment->age >= 50 && $consultNcdRiskAssessment->age <= 59) {
                $age = 50;
            } elseif ($consultNcdRiskAssessment->age >= 60 && $consultNcdRiskAssessment->age <= 69) {
                $age = 60;
            } elseif ($consultNcdRiskAssessment->age >= 70) {
                $age = 70;
            }

            if ($consultNcdRiskAssessment->avg_systolic <= 139) {
                $sbp = 120;
            } elseif ($consultNcdRiskAssessment->avg_systolic >= 140 && $consultNcdRiskAssessment->avg_systolic <= 159) {
                $sbp = 140;
            } elseif ($consultNcdRiskAssessment->avg_systolic >= 160 && $consultNcdRiskAssessment->avg_systolic <= 179) {
                $sbp = 160;
            } elseif ($consultNcdRiskAssessment->avg_systolic >= 180) {
                $sbp = 180;
            } else {
                $sbp = 'N/A';
            }
            if ($consultNcdRiskAssessment->location == 2) {
                $location = 'facility';
            } else {
                $location = 'community';
            }

            $riskStrat = LibNcdRiskStratificationChart::query()
                ->join('lib_ncd_risk_stratifications', 'lib_ncd_risk_stratification_charts.color', '=', 'lib_ncd_risk_stratifications.risk_color')
                ->where('type', '=', $location)
                ->where('diabetes_present', $presence_diabetes)
                ->where('sbp', '=', $sbp)
                ->where('age', '=', $age)
                ->where('smoking_status', '=', $smoking)
                ->where('gender', '=', $consultNcdRiskAssessment->gender)
                ->where('cholesterol', '=', $totalCholesterol)
                ->first();

            return $riskStrat;
        }
    }
}
