<?php

namespace App\Services\NCD;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\ConsultNcdRiskScreeningBloodLipid;

class NcdRiskStratificationChartService
{
    /**
     * @param array $request
     * @return mixed
     */
    public function getRiskStratificationChart(array $request)
    {
        $riskAssessment = ConsultNcdRiskAssessment::where('id', $request['id'])->first();
        $riskAssessment2 = ConsultNcdRiskScreeningBloodLipid::where('id', $request['id'])->first();

        dd($request);

        $data = LibNcdRiskStratificationChart::join('lib_ncd_risk_stratifications', 'risk_color', '=', 'color');
        $data = $riskAssessment->where('gender', '=', $riskAssessment->gender);
        $data = $riskAssessment->where('sbp', '=', $riskAssessment->avg_systolic);
        $data = $riskAssessment->where('type', '=', $riskAssessment->location);

            if($riskAssessment->location == '2') {
                $totalCholesterol = round($riskAssessment2->total_cholesterol);
                if($totalCholesterol > 8){
                  $totalCholesterol = 8;
                } elseif($totalCholesterol>0 && $totalCholesterol<=4){
                  $totalCholesterol = 4;
                }
                $data = $data->where('cholesterol', '=', $totalCholesterol);
              };

            if($riskAssessment->smoking = 1) {
                $smoking = 0;
                if($riskAssessment->smoking = 2){
                  $smoking = 0;
                } elseif($riskAssessment->smoking = 3 && $riskAssessment->smoking = 4){
                  $smoking = 1;
                }
                $data = $data->where('smoking_status', '=', $smoking);
            }

            if($riskAssessment->presence_diabetes = 'N') {
                $presence_diabetes = 0;
                if($riskAssessment->presence_diabetes = 'Y'){
                  $presence_diabetes = 1;
                } elseif($riskAssessment->smoking = 'X'){
                  $presence_diabetes = 0;
                }
                $data = $data->where('diabetes_present', '=', $presence_diabetes);
            }

            if($riskAssessment->age >= 20 && $riskAssessment->age <= 49) {
                $age = 40;
                if($riskAssessment->age >= 50 && $riskAssessment->age <= 59){
                  $age = 50;
                } elseif($riskAssessment->age >= 60 && $riskAssessment->age <= 69){
                  $age = 60;
                }
                  elseif($riskAssessment->age >= 70){
                  $age = 70;
                }
                $data = $data->where('age', '=', $age);
        $data = $data->first();
        return $data;
        }
    }
}
