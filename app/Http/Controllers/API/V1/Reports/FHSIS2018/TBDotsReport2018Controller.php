<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\TBDots\TBDotsReportService;
use Illuminate\Http\Request;

class TBDotsReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TBDotsReportService $tbdotsReportService)
    {
        $projected_population = $tbdotsReportService->get_projected_population()->get();

        //1. No. of notified TB cases, all forms - Total
        $indicator1_male = $tbdotsReportService->get_notified_tb_cases_all_forms($request, 'M')->get();
        $indicator1_female = $tbdotsReportService->get_notified_tb_cases_all_forms($request, 'F')->get();

        //2. No. of registered bacteriologically confirmed drug resistant TB (RR/MDR-TB Cases)
        $indicator2_male = $tbdotsReportService->get_drtb_drug_resistant_confirmed($request, 'M')->get();
        $indicator2_female = $tbdotsReportService->get_drtb_drug_resistant_confirmed($request, 'F')->get();

        //3. Number of TB, all forms that are cured and completely treated - Total
        $indicator3_male = $tbdotsReportService->get_tb_outcome_cured_and_complete($request, 'M')->get();
        $indicator3_female = $tbdotsReportService->get_tb_outcome_cured_and_complete($request, 'F')->get();

        //4. Number of registered bacteriologically confirmed drug resistant TB (RR/MDR-TB Cases) that are cured and completed treatment
        $indicator4_male = $tbdotsReportService->get_tb_drtb_outcome_cured_and_complete($request, 'M')->get();
        $indicator4_female = $tbdotsReportService->get_tb_drtb_outcome_cured_and_complete($request, 'F')->get();

        return [

            //Get catchment population
            'projected_population' => $projected_population,

            //1. No. of notified TB cases, all forms - Total
            'indicator1_male' => $indicator1_male,
            'indicator1_female' => $indicator1_female,

            //2. No. of registered bacteriologically confirmed drug resistant TB (RR/MDR-TB Cases)
            'indicator2_male' => $indicator2_male,
            'indicator2_female' => $indicator2_female,

            //3. Number of TB, all forms that are cured and completely treated - Total
            'indicator3_male' => $indicator3_male,
            'indicator3_female' => $indicator3_female,

            //4. Number of registered acteriologically confirmed drug resistant TB (RR/MDR-TB Cases) that are cured and completed treatment
            'indicator4_male' => $indicator4_male,
            'indicator4_female' => $indicator4_female,

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
