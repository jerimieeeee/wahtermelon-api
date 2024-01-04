<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\NCD\NcdReportService;
use Illuminate\Http\Request;

class NcdReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, NcdReportService $ncdReportService)
    {
        //Risk-Assessed PHILPEN
        $assessed_male = $ncdReportService->get_risk_assessed($request, 'M')->get();
        $assessed_female = $ncdReportService->get_risk_assessed($request, 'F')->get();

        //Risk-Assessed PHILPEN Smoker
        $assessed_male_smoker = $ncdReportService->get_risk_assessed_smoker($request, 'M')->get();
        $assessed_female_smoker = $ncdReportService->get_risk_assessed_smoker($request, 'F')->get();

        //Risk-Assessed PHILPEN Alcohol
        $assessed_male_alcohol = $ncdReportService->get_risk_assessed_alcohol($request, 'M')->get();
        $assessed_female_alcohol = $ncdReportService->get_risk_assessed_alcohol($request, 'F')->get();

        //Risk-Assessed PHILPEN Obese
        $assessed_male_obese = $ncdReportService->get_risk_assessed_obese($request, 'M')->get();
        $assessed_female_obese = $ncdReportService->get_risk_assessed_obese($request, 'F')->get();

        //Risk-Assessed PHILPEN Hypertensive
        $assessed_male_hypertensive = $ncdReportService->hypertensive_adult($request, 'M')->get();
        $assessed_female_hypertensive = $ncdReportService->hypertensive_adult($request, 'F')->get();

        //Risk-Assessed PHILPEN Type 2 Diabetes
        $assessed_male_diabetes = $ncdReportService->diabetes_adult($request, 'M')->get();
        $assessed_female_diabetes = $ncdReportService->diabetes_adult($request, 'F')->get();

        //Senior Citizen with PPV vaccine
        $male_senior_ppv = $ncdReportService->senior_ppv($request, 'M')->get();
        $female_senior_ppv = $ncdReportService->senior_ppv($request, 'F')->get();

        //Senior Citizen with Influenza Vaccine
        $male_senior_influenza = $ncdReportService->senior_influenza($request, 'M')->get();
        $female_senior_influenza = $ncdReportService->senior_influenza($request, 'F')->get();

        return [

            //Risk-Assessed PHILPEN
            'assessed_male' => $assessed_male,
            'assessed_female' => $assessed_female,

            //Risk-Assessed PHILPEN Smoker
            'assessed_male_smoker' => $assessed_male_smoker,
            'assessed_female_smoker' => $assessed_female_smoker,

            //Risk-Assessed PHILPEN Alcohol
            'assessed_male_alcohol' => $assessed_male_alcohol,
            'assessed_female_alcohol' => $assessed_female_alcohol,

            //Risk-Assessed PHILPEN Obese
            'assessed_male_obese' => $assessed_male_obese,
            'assessed_female_obese' => $assessed_female_obese,

            //Risk-Assessed PHILPEN Hypertensive
            'assessed_male_hypertensive' => $assessed_male_hypertensive,
            'assessed_female_hypertensive' => $assessed_female_hypertensive,

            //Risk-Assessed PHILPEN Type 2 Diabetes
            'assessed_male_diabetes' => $assessed_male_diabetes,
            'assessed_female_diabetes' => $assessed_female_diabetes,

            //Senior Citizen with PPV vaccine
            'male_senior_ppv' => $male_senior_ppv,
            'female_senior_ppv' => $female_senior_ppv,

            //Senior Citizen with Influenza Vaccine
            'male_senior_influenza' => $male_senior_influenza,
            'female_senior_influenza' => $female_senior_influenza

        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
