<?php

namespace App\Http\Controllers\API\V1\Reports\Household;

use App\Http\Controllers\Controller;
use App\Services\Household\HouseholdProfilingReportService;
use Illuminate\Http\Request;

class HouseholdProfilingReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, HouseholdProfilingReportService $householdProfilingReportService)
    {
        //Summary household 4PS
        $summary_household_4ps = $householdProfilingReportService->get_household_profiling_summary($request, '4ps')->get();

        //Summary household NON-4PS
        $summary_household_non_4ps = $householdProfilingReportService->get_household_profiling_summary($request, 'non-4ps')->get();

        //Water Source 4PS
        $water_source_level1_4ps = $householdProfilingReportService->get_household_profiling_water_source($request, '4ps', 1)->get();
        $water_source_level2_4ps = $householdProfilingReportService->get_household_profiling_water_source($request, '4ps', 2)->get();
        $water_source_level3_4ps = $householdProfilingReportService->get_household_profiling_water_source($request, '4ps', 3)->get();

        //Water Source NON-4PS
        $water_source_level1_non_4ps = $householdProfilingReportService->get_household_profiling_water_source($request, 'non-4ps', 1)->get();
        $water_source_level2_non_4ps = $householdProfilingReportService->get_household_profiling_water_source($request, 'non-4ps', 2)->get();
        $water_source_level3_non_4ps = $householdProfilingReportService->get_household_profiling_water_source($request, 'non-4ps', 3)->get();

        //Sanitary Toilet Facilities 4PS
        $sanitary_toilet_facility_1_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, '4ps', 1)->get();
        $sanitary_toilet_facility_2_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, '4ps', 2)->get();
        $sanitary_toilet_facility_3_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, '4ps', 3)->get();

        //Sanitary Toilet Facilities NON-4PS
        $sanitary_toilet_facility_1_non_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, 'non-4ps', 1)->get();
        $sanitary_toilet_facility_2_non_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, 'non-4ps', 2)->get();
        $sanitary_toilet_facility_3_non_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, 'non-4ps', 3)->get();

        //Unsanitary Toilet Facilities 4PS
        $unsanitary_toilet_facility_5_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, '4ps', 5)->get();
        $unsanitary_toilet_facility_6_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, '4ps', 6)->get();
        $unsanitary_toilet_facility_7_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, '4ps', 7)->get();
        $unsanitary_toilet_facility_8_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, '4ps', 8)->get();

        //Unsanitary Toilet Facilities NON-4PS
        $unsanitary_toilet_facility_5_non_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, 'non-4ps', 5)->get();
        $unsanitary_toilet_facility_6_non_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, 'non-4ps', 6)->get();
        $unsanitary_toilet_facility_7_non_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, 'non-4ps', 7)->get();
        $unsanitary_toilet_facility_8_non_4ps = $householdProfilingReportService->get_household_profiling_toilet_facilities($request, 'non-4ps', 8)->get();

        return [
            //Summary Household
            'summary_household_4ps' => $summary_household_4ps,
            'summary_household_non_4ps' => $summary_household_non_4ps,

            //Water Source 4PS
            'water_source_level1_4ps' => $water_source_level1_4ps,
            'water_source_level2_4ps' => $water_source_level2_4ps,
            'water_source_level3_4ps' => $water_source_level3_4ps,

            //Water Source NON-4PS
            'water_source_level1_non_4ps' => $water_source_level1_non_4ps,
            'water_source_level2_non_4ps' => $water_source_level2_non_4ps,
            'water_source_level3_non_4ps' => $water_source_level3_non_4ps,

            //Sanitary Toilet Facilities 4PS
            'sanitary_toilet_facility_1_4ps' => $sanitary_toilet_facility_1_4ps,
            'sanitary_toilet_facility_2_4ps' => $sanitary_toilet_facility_2_4ps,
            'sanitary_toilet_facility_3_4ps' => $sanitary_toilet_facility_3_4ps,

            //Sanitary Toilet Facilities NON-4PS
            'sanitary_toilet_facility_1_non_4ps' => $sanitary_toilet_facility_1_non_4ps,
            'sanitary_toilet_facility_2_non_4ps' => $sanitary_toilet_facility_2_non_4ps,
            'sanitary_toilet_facility_3_non_4ps' => $sanitary_toilet_facility_3_non_4ps,

            //Unsanitary Toilet Facilities 4PS
            'unsanitary_toilet_facility_5_4ps' => $unsanitary_toilet_facility_5_4ps,
            'unsanitary_toilet_facility_6_4ps' => $unsanitary_toilet_facility_6_4ps,
            'unsanitary_toilet_facility_7_4ps' => $unsanitary_toilet_facility_7_4ps,
            'unsanitary_toilet_facility_8_4ps' => $unsanitary_toilet_facility_8_4ps,

            //Unsanitary Toilet Facilities NON-4PS
            'unsanitary_toilet_facility_5_non_4ps' => $unsanitary_toilet_facility_5_non_4ps,
            'unsanitary_toilet_facility_6_non_4ps' => $unsanitary_toilet_facility_6_non_4ps,
            'unsanitary_toilet_facility_7_non_4ps' => $unsanitary_toilet_facility_7_non_4ps,
            'unsanitary_toilet_facility_8_non_4ps' => $unsanitary_toilet_facility_8_non_4ps,

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
