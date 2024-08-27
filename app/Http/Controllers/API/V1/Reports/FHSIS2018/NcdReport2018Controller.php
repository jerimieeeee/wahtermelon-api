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
        //Projected Population
        $projected_population = $ncdReportService->get_projected_population()->get();

        //Risk-Assessed PHILPEN
        $assessed_male = $ncdReportService->get_risk_assessed($request, 'M', 'normal')->get();
        $assessed_male_senior = $ncdReportService->get_risk_assessed($request, 'M', 'senior')->get();

        $assessed_female = $ncdReportService->get_risk_assessed($request, 'F', 'normal')->get();
        $assessed_female_senior = $ncdReportService->get_risk_assessed($request, 'F', 'senior')->get();

        //Risk-Assessed PHILPEN Smoker
        $assessed_male_smoker = $ncdReportService->get_risk_assessed_smoker($request, 'M', 'normal')->get();
        $assessed_male_smoker_senior = $ncdReportService->get_risk_assessed_smoker($request, 'M', 'senior')->get();

        $assessed_female_smoker = $ncdReportService->get_risk_assessed_smoker($request, 'F', 'normal')->get();
        $assessed_female_smoker_senior = $ncdReportService->get_risk_assessed_smoker($request, 'F', 'senior')->get();

        //Risk-Assessed PHILPEN Alcohol
        $assessed_male_alcohol = $ncdReportService->get_risk_assessed_alcohol($request, 'M', 'normal')->get();
        $assessed_male_alcohol_senior = $ncdReportService->get_risk_assessed_alcohol($request, 'M', 'senior')->get();

        $assessed_female_alcohol = $ncdReportService->get_risk_assessed_alcohol($request, 'F', 'normal')->get();
        $assessed_female_alcohol_senior = $ncdReportService->get_risk_assessed_alcohol($request, 'F', 'senior')->get();

        //Risk-Assessed PHILPEN Obese
        $assessed_male_obese = $ncdReportService->get_risk_assessed_obese($request, 'M', 'normal')->get();
        $assessed_male_obese_senior = $ncdReportService->get_risk_assessed_obese($request, 'M', 'senior')->get();

        $assessed_female_obese = $ncdReportService->get_risk_assessed_obese($request, 'F', 'normal')->get();
        $assessed_female_obese_senior = $ncdReportService->get_risk_assessed_obese($request, 'F', 'senior')->get();

        //Risk-Assessed PHILPEN Hypertensive
        $assessed_male_hypertensive = $ncdReportService->hypertensive_adult($request, 'M', 'normal')->get();
        $assessed_male_hypertensive_senior = $ncdReportService->hypertensive_adult($request, 'M', 'senior')->get();

        $assessed_female_hypertensive = $ncdReportService->hypertensive_adult($request, 'F', 'normal')->get();
        $assessed_female_hypertensive_senior = $ncdReportService->hypertensive_adult($request, 'F', 'senior')->get();

        //Risk-Assessed PHILPEN Type 2 Diabetes
        $assessed_male_diabetes = $ncdReportService->diabetes_adult($request, 'M', 'normal')->get();
        $assessed_male_diabetes_senior = $ncdReportService->diabetes_adult($request, 'M', 'senior')->get();

        $assessed_female_diabetes = $ncdReportService->diabetes_adult($request, 'F', 'normal')->get();
        $assessed_female_diabetes_senior = $ncdReportService->diabetes_adult($request, 'F', 'senior')->get();

        //Senior Citizen with PPV vaccine
        $male_senior_ppv = $ncdReportService->senior_ppv($request, 'M')->get();
        $female_senior_ppv = $ncdReportService->senior_ppv($request, 'F')->get();

        //Senior Citizen with Influenza Vaccine
        $male_senior_influenza = $ncdReportService->senior_influenza($request, 'M')->get();
        $female_senior_influenza = $ncdReportService->senior_influenza($request, 'F')->get();

        return [

            //Projected Population
            'projected_population' => $projected_population,

            //Risk-Assessed PHILPEN
            'assessed_male' => $assessed_male,
            'assessed_male_senior' => $assessed_male_senior,

            'assessed_female' => $assessed_female,
            'assessed_female_senior' => $assessed_female_senior,

            //Risk-Assessed PHILPEN Smoker
            'assessed_male_smoker' => $assessed_male_smoker,
            'assessed_male_smoker_senior' => $assessed_male_smoker_senior,

            'assessed_female_smoker' => $assessed_female_smoker,
            'assessed_female_smoker_senior' => $assessed_female_smoker_senior,

            //Risk-Assessed PHILPEN Alcohol
            'assessed_male_alcohol' => $assessed_male_alcohol,
            'assessed_male_alcohol_senior' => $assessed_male_alcohol_senior,

            'assessed_female_alcohol' => $assessed_female_alcohol,
            'assessed_female_alcohol_senior' => $assessed_female_alcohol_senior,

            //Risk-Assessed PHILPEN Obese
            'assessed_male_obese' => $assessed_male_obese,
            'assessed_male_obese_senior' => $assessed_male_obese_senior,

            'assessed_female_obese' => $assessed_female_obese,
            'assessed_female_obese_senior' => $assessed_female_obese_senior,

            //Risk-Assessed PHILPEN Hypertensive
            'assessed_male_hypertensive' => $assessed_male_hypertensive,
            'assessed_male_hypertensive_senior' => $assessed_male_hypertensive_senior,

            'assessed_female_hypertensive' => $assessed_female_hypertensive,
            'assessed_female_hypertensive_senior' => $assessed_female_hypertensive_senior,

            //Risk-Assessed PHILPEN Type 2 Diabetes
            'assessed_male_diabetes' => $assessed_male_diabetes,
            'assessed_male_diabetes_senior' => $assessed_male_diabetes_senior,

            'assessed_female_diabetes' => $assessed_female_diabetes,
            'assessed_female_diabetes_senior' => $assessed_female_diabetes_senior,

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
