<?php

namespace App\Services\NCD;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;

class NcdRiskStratificationChartService
{
    /**
     * @return mixed
     */
    public function getRiskStratificationChart($request, $consultNcdRiskAssessment = null)
    {
        // If a specific ConsultNcdRiskAssessment is provided, use it
        if ($consultNcdRiskAssessment) {
            $consultNcdRiskAssessments = collect([$consultNcdRiskAssessment]);
        } else {
            // Otherwise, fetch all ConsultNcdRiskAssessment records based on the request
            $consultNcdRiskAssessments = ConsultNcdRiskAssessment::where(function ($query) use ($request) {
                if (isset($request->consult_id)) {
                    $query->where('consult_id', $request->consult_id);
                }
                if (isset($request->patient_id)) {
                    $query->where('patient_id', $request->patient_id);
                }
            })->get();
        }

        // If no records are found, return null
        if ($consultNcdRiskAssessments->isEmpty()) {
            return null;
        }

        // Fetch risk stratification data for each record
        $riskStrats = [];
        foreach ($consultNcdRiskAssessments as $consultNcdRiskAssessment) {
            $totalCholesterol = 0;
            $age = 40;

            // Calculate total cholesterol
            if ($consultNcdRiskAssessment->location == 2) {
                $totalCholesterol = round($consultNcdRiskAssessment->riskScreeningLipid->total_cholesterol ?? 0);
                if ($totalCholesterol > 8) {
                    $totalCholesterol = 8;
                } elseif ($totalCholesterol > 0 && $totalCholesterol <= 4) {
                    $totalCholesterol = 4;
                }
            }

            // Determine smoking status
            $smoking = match ($consultNcdRiskAssessment->smoking) {
                3, 4, 5 => 1,
                default => 0,
            };

            // Determine presence of diabetes
            $presence_diabetes = match ($consultNcdRiskAssessment->presence_diabetes) {
                'Y' => 1,
                default => 0,
            };

            // Determine age group
            if ($consultNcdRiskAssessment->age >= 20 && $consultNcdRiskAssessment->age <= 49) {
                $age = 40;
            } elseif ($consultNcdRiskAssessment->age >= 50 && $consultNcdRiskAssessment->age <= 59) {
                $age = 50;
            } elseif ($consultNcdRiskAssessment->age >= 60 && $consultNcdRiskAssessment->age <= 69) {
                $age = 60;
            } elseif ($consultNcdRiskAssessment->age >= 70) {
                $age = 70;
            }

            // Determine systolic blood pressure (SBP)
            $sbp = match (true) {
                $consultNcdRiskAssessment->avg_systolic <= 139 => 120,
                $consultNcdRiskAssessment->avg_systolic >= 140 && $consultNcdRiskAssessment->avg_systolic <= 159 => 140,
                $consultNcdRiskAssessment->avg_systolic >= 160 && $consultNcdRiskAssessment->avg_systolic <= 179 => 160,
                $consultNcdRiskAssessment->avg_systolic >= 180 => 180,
                default => 'N/A',
            };

            // Determine location
            $location = $consultNcdRiskAssessment->location == 2 ? 'facility' : 'community';

            // Fetch risk stratification data
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

            // Attach the risk stratification data to the current record
            if ($riskStrat) {
                $riskStrats[$consultNcdRiskAssessment->id] = $riskStrat;
            }
        }

        return $riskStrats;
    }
}
