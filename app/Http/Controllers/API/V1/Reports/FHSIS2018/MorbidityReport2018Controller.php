<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Morbidity\MorbidityReportService;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group FHSIS Reports 2018
 *
 * APIs for managing Morbidity Report Information
 *
 * @subgroup M1 Child Care Report
 *
 * @subgroupDescription M1 FHSIS 2018 Morbidity Report.
 */
class MorbidityReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, MorbidityReportService $morbidityReportService, CategoryFilterService $categoryFilterService)
    {
        //Projected Population
        $projected_population = $categoryFilterService->get_projected_population()->get();
        $g = $morbidityReportService->get_morbidity_report_all($request)->get();

        return [
            'projected_population' => $projected_population,
            'data' => $g,
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
