<?php

namespace App\Services\NCD;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;

class NcdRiskStratificationChartService
{
    /**
     * @return mixed
     */
    public function getRiskStratificationChart($request)
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
    }
}
