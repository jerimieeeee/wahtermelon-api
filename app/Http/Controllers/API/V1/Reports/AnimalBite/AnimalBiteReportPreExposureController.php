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

        //PART 1
        $part1 = $animalbite->get_ab_pre_exp_prophylaxis($request)->get();

        //PART 1 OTHERS
        $part1_others = $animalbite->get_ab_pre_exp_prophylaxis_others($request)->get();

        //PART 2
        $part2 = $animalbite->get_previous_quarter_cat2_cat3($request)->get();

        //PART 2 OTHERS
        $part2_others = $animalbite->get_previous_quarter_cat2_cat3_others($request)->get();

        if (auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL) {
            $part1 = $part1->groupBy('barangay_name');
            $part1_others = $part1_others->groupBy('municipality_name');
            $part2 = $part2->groupBy('barangay_name');
            $part2_others = $part2_others->groupBy('municipality_name');
        }

        // Apply groupBy for municipality_name only if reports_flag is 1
        if (auth()->user()->reports_flag == 1) {
            $part1 = $part1->groupBy('municipality_name');
            $part1_others = $part1_others->groupBy('municipality_name');
            $part2 = $part2->groupBy('municipality_name');
            $part2_others = $part2_others->groupBy('municipality_name');
        }

        return [
            'projected_population' => $total_population,
            'data' => $part1,
            'data1_others' => $part1_others,
            'data2' => $part2,
            'data2_others' => $part2_others,
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
