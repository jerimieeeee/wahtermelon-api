<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Mortality\MortalityReportService;
use Illuminate\Http\Request;

class MortalityReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MortalityReportService $mortalityReportService)
    {
        //Projected Population
        $projected_population = $mortalityReportService->get_projected_population()->get();
        $g = $mortalityReportService->get_mortality_natality($request)->get();

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
