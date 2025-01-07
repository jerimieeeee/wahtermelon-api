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
        $total_population = $categoryFilterService->get_projected_population()->get();

        $part1 = $animalbite->get_ab_pre_exp_prophylaxis($request)->get();
        $part1_others = $animalbite->get_ab_pre_exp_prophylaxis_others($request)->get();
        $part2 = $animalbite->get_previous_quarter_cat2_cat3($request)->get();

        if (auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL) {
            $part1 = $part1->groupBy('barangay_name');
            $part1_others = $part1_others->groupBy('barangay_name');
            $part2 = $part2->groupBy('barangay_name');
        }

        // Apply groupBy for municipality_name only if reports_flag is 1
        if (auth()->user()->reports_flag == 1) {
            $part1 = $part1->groupBy('municipality_name');
            $part1_others = $part1_others->groupBy('municipality_name');
            $part2 = $part2->groupBy('municipality_name');
        }

        return [
            'projected_population' => $total_population,
            'data' => $part1,
            'other_muncity' => $part1_others,
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
