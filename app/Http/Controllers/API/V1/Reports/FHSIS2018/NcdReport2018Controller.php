<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\NCD\NcdReportService;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Http\Request;

class NcdReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, NcdReportService $ncdReportService, CategoryFilterService $categoryFilterService)
    {
        //Projected Population
        $projected_population = $categoryFilterService->get_projected_population()->get();

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

        //Risk-Assessed PHILPEN Hypertensive Old Case
        $assessed_male_hypertensive_old_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'M', 'normal', 'old')->get();
        $assessed_male_hypertensive_senior_old_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'M', 'senior', 'old')->get();

        $assessed_female_hypertensive_old_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'F', 'normal', 'old')->get();
        $assessed_female_hypertensive_senior_old_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'F', 'senior', 'old')->get();

        //Risk-Assessed PHILPEN Hypertensive New Case
        $assessed_male_hypertensive_new_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'M', 'normal', 'new')->get();
        $assessed_male_hypertensive_senior_new_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'M', 'senior', 'new')->get();

        $assessed_female_hypertensive_new_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'F', 'normal', 'new')->get();
        $assessed_female_hypertensive_senior_new_case = $ncdReportService->hypertensive_adult_old_new_case($request, 'F', 'senior', 'new')->get();

        //Risk-Assessed PHILPEN Type 2 Diabetes
        $assessed_male_diabetes = $ncdReportService->diabetes_adult($request, 'M', 'normal')->get();
        $assessed_male_diabetes_senior = $ncdReportService->diabetes_adult($request, 'M', 'senior')->get();

        $assessed_female_diabetes = $ncdReportService->diabetes_adult($request, 'F', 'normal')->get();
        $assessed_female_diabetes_senior = $ncdReportService->diabetes_adult($request, 'F', 'senior')->get();

        //Risk-Assessed PHILPEN Type 2 Diabetes Old Case
        $assessed_male_diabetes_old_case = $ncdReportService->diabetes_adult_old_new_case($request, 'M', 'normal', 'old')->get();
        $assessed_male_diabetes_senior_old_case = $ncdReportService->diabetes_adult_old_new_case($request, 'M', 'senior', 'old')->get();

        $assessed_female_diabetes_old_case = $ncdReportService->diabetes_adult_old_new_case($request, 'F', 'normal', 'old')->get();
        $assessed_female_diabetes_senior_old_case = $ncdReportService->diabetes_adult_old_new_case($request, 'F', 'senior', 'old')->get();

        //Risk-Assessed PHILPEN Type 2 Diabetes New Case
        $assessed_male_diabetes_new_case = $ncdReportService->diabetes_adult_old_new_case($request, 'M', 'normal', 'new')->get();
        $assessed_male_diabetes_senior_new_case = $ncdReportService->diabetes_adult_old_new_case($request, 'M', 'senior', 'new')->get();

        $assessed_female_diabetes_new_case = $ncdReportService->diabetes_adult_old_new_case($request, 'F', 'normal', 'new')->get();
        $assessed_female_diabetes_senior_new_case = $ncdReportService->diabetes_adult_old_new_case($request, 'F', 'senior', 'new')->get();

        //Senior Citizen with PPV vaccine
        $male_senior_ppv = $ncdReportService->senior_ppv($request, 'M')->get();
        $female_senior_ppv = $ncdReportService->senior_ppv($request, 'F')->get();

        //Senior Citizen with Influenza Vaccine
        $male_senior_influenza = $ncdReportService->senior_influenza($request, 'M')->get();
        $female_senior_influenza = $ncdReportService->senior_influenza($request, 'F')->get();

        //Senior Citizen screened with eye problems
        $male_senior_eye_problem = $ncdReportService->eye_problems_disease($request, 'M', 'eye_problem')->get();
        $female_senior_eye_problem = $ncdReportService->eye_problems_disease($request, 'F', 'eye_problem')->get();

        //Senior Citizen screened with eye refer prof
        $male_senior_eye_refer_prof = $ncdReportService->eye_problems_disease($request, 'M', 'eye_refer_prof')->get();
        $female_senior_eye_refer_prof = $ncdReportService->eye_problems_disease($request, 'F', 'eye_refer_prof')->get();

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

            //Risk-Assessed PHILPEN Hypertensive Old Case
            'assessed_male_hypertensive_old_case' => $assessed_male_hypertensive_old_case,
            'assessed_male_hypertensive_senior_old_case' => $assessed_male_hypertensive_senior_old_case,

            'assessed_female_hypertensive_old_case' => $assessed_female_hypertensive_old_case,
            'assessed_female_hypertensive_senior_old_case' => $assessed_female_hypertensive_senior_old_case,

            //Risk-Assessed PHILPEN Hypertensive New Case
            'assessed_male_hypertensive_new_case' => $assessed_male_hypertensive_new_case,
            'assessed_male_hypertensive_senior_new_case' => $assessed_male_hypertensive_senior_new_case,

            'assessed_female_hypertensive_new_case' => $assessed_female_hypertensive_new_case,
            'assessed_female_hypertensive_senior_new_case' => $assessed_female_hypertensive_senior_new_case,

            'assessed_female_hypertensive' => $assessed_female_hypertensive,
            'assessed_female_hypertensive_senior' => $assessed_female_hypertensive_senior,

            //Risk-Assessed PHILPEN Type 2 Diabetes
            'assessed_male_diabetes' => $assessed_male_diabetes,
            'assessed_male_diabetes_senior' => $assessed_male_diabetes_senior,

            'assessed_female_diabetes' => $assessed_female_diabetes,
            'assessed_female_diabetes_senior' => $assessed_female_diabetes_senior,

            //Risk-Assessed PHILPEN Type 2 Diabetes Old Case
            'assessed_male_diabetes_old_case' => $assessed_male_diabetes_old_case,
            'assessed_male_diabetes_senior_old_case' => $assessed_male_diabetes_senior_old_case,

            'assessed_female_diabetes_old_case' => $assessed_female_diabetes_old_case,
            'assessed_female_diabetes_senior_old_case' => $assessed_female_diabetes_senior_old_case,

            //Risk-Assessed PHILPEN Type 2 Diabetes New Case
            'assessed_male_diabetes_new_case' => $assessed_male_diabetes_new_case,
            'assessed_male_diabetes_senior_new_case' => $assessed_male_diabetes_senior_new_case,

            'assessed_female_diabetes_new_case' => $assessed_female_diabetes_new_case,
            'assessed_female_diabetes_senior_new_case' => $assessed_female_diabetes_senior_new_case,

            //Senior Citizen with PPV vaccine
            'male_senior_ppv' => $male_senior_ppv,
            'female_senior_ppv' => $female_senior_ppv,

            //Senior Citizen with Influenza Vaccine
            'male_senior_influenza' => $male_senior_influenza,
            'female_senior_influenza' => $female_senior_influenza,

            //Senior Citizen screened with eye problems
            'male_senior_eye_problem' => $male_senior_eye_problem,
            'female_senior_eye_problem' => $female_senior_eye_problem,

            //Senior Citizen screened with eye refer prof
            'male_senior_eye_refer_prof' => $male_senior_eye_refer_prof,
            'female_senior_eye_refer_prof' => $female_senior_eye_refer_prof,

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
