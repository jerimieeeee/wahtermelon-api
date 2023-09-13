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
    public function index(Request $request, TBDotsReportService $TBDotsReportService)
    {
        $catchment_population = $TBDotsReportService->get_projected_population()->get();

        //2. No. of registered bacteriologically confirmed drug resistant TB (RR/MDR-TB Cases)
        $indicator2_male = $TBDotsReportService->get_dtrb_confirmed($request, 'M')->get();
        $indicator2_female = $TBDotsReportService->get_dtrb_confirmed($request, 'F')->get();

        //3. Number of TB, all forms that are cured and completely treated - Total
        $indicator3_male = $TBDotsReportService->get_tb_outcome_cured_and_complete($request, 'M')->get();
        $indicator3_female = $TBDotsReportService->get_tb_outcome_cured_and_complete($request, 'F')->get();

        return [

            //2. No. of registered bacteriologically confirmed drug resistant TB (RR/MDR-TB Cases)
            'indicator2_male' => $indicator2_male,
            'indicator2_female' => $indicator2_female,

            //3. Number of TB, all forms that are cured and completely treated - Total
            'indicator3_male' => $indicator3_male,
            'indicator3_female' => $indicator3_female,
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
