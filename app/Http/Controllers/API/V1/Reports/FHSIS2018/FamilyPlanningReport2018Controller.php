<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\FamilyPlanning\FamilyPlanningReportService;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group FHSIS Reports 2018
 *
 * APIs for managing Family Planning Report Information
 *
 * @subgroup M1 Family Planning Report
 *
 * @subgroupDescription M1 Family Planning Report.
 */
class FamilyPlanningReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, FamilyPlanningReportService $familyPlanningReportService)
    {
        $g = $familyPlanningReportService->get_fp_report($request)->get();

        return $g;
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
