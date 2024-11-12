<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\MaternalCare\MaternalCareReportService;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group FHSIS Reports 2018
 *
 * APIs for managing Maternal Care Report Information
 *
 * @subgroup M1 Maternal Care Report
 *
 * @subgroupDescription M1 FHSIS 2018 Maternal Care Report.
 */
class MaternalCareReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, MaternalCareReportService $maternalCareReportService)
    {
        //Catchment Population
        $catchment_population = $maternalCareReportService->get_projected_population()->get();

        $anc = $maternalCareReportService->get_4anc_give_birth($request)->get();

        return [
            '4anc_give_birth' => $anc,
        ];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
