<?php

namespace App\Http\Controllers\API\V1\Reports\AnimalBite;

use App\Http\Controllers\Controller;
use App\Services\AnimalBite\AnimalBiteReportCohortService;
use App\Services\AnimalBite\AnimalBiteReportPreExposureService;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Http\Request;

class AnimalBiteReportPreExposureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AnimalBiteReportPreExposureService $animalbite, CategoryFilterService $categoryFilterService)
    {
        //Projected Population
        $projected_population = $categoryFilterService->get_projected_population()->get();

        $part1 = $animalbite->get_ab_pre_exp_prophylaxis($request)->get()->groupBy('municipality_name');
//        $part2 = $animalbite->get_previous_quarter_cat2_cat3($request)->get()->groupBy('municipality_name');

        return [
            'projected_population' => $projected_population,
            'data' => $part1,
//            'data2' => $part2,
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
