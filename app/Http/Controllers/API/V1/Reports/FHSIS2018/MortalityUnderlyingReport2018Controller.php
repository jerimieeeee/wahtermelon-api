<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Mortality\MortalityUnderlyingReportService;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Http\Request;

class MortalityUnderlyingReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MortalityUnderlyingReportService $mortalityUnderlyingReportService, CategoryFilterService $categoryFilterService)
    {
        //Projected Population
        $projected_population = $categoryFilterService->get_projected_population()->get();
        $g = $mortalityUnderlyingReportService->get_mortality_underlying($request)->get();

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
