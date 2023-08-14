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

        //Philhealth Direct Contributors
        $philhealth_direct_contributors = $householdProfilingReportService->get_household_profiling_philhealth($request, 'direct')->get();

        //Philhealth Indirect Contributors
        $philhealth_indirect_contributors = $householdProfilingReportService->get_household_profiling_philhealth($request, 'indirect')->get();

        //Philhealth Unknown
        $philhealth_unknown = $householdProfilingReportService->get_household_profiling_philhealth($request, 'unknown')->get();

        //Sex
        $sex_male = $householdProfilingReportService->get_household_profiling_sex($request, 'M')->get();
        $sex_female = $householdProfilingReportService->get_household_profiling_sex($request, 'F')->get();

        //DE
        $indegenous = $householdProfilingReportService->get_household_profiling_ethnicity($request, 'indegenous')->get();
        $non_indegenous = $householdProfilingReportService->get_household_profiling_ethnicity($request, 'non-indegenous')->get();

        //Educational Attainment 4PS
        $pre_school_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 9)->get();
        $elementary_undergraduate_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 10)->get();
        $elementary_student_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 11)->get();
        $elementary_graduate_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 1)->get();
        $highschool_undergraduate_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 12)->get();
        $highschool_student_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 13)->get();
        $highschool_graduate_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 2)->get();
        $senior_highschool_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 14)->get();
        $als_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 15)->get();
        $college_undergraduate_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 16)->get();
        $college_graduate_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 3)->get();
        $college_student_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 17)->get();
        $post_graduate_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 4)->get();
        $vocational_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 7)->get();
        $not_applicable_4ps = $householdProfilingReportService->get_household_profiling_education($request, '4ps', 6)->get();

        //Educational Attainment NON-4PS
        $pre_school_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 9)->get();
        $elementary_undergraduate_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 10)->get();
        $elementary_student_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 11)->get();
        $elementary_graduate_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 1)->get();
        $highschool_undergraduate_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 12)->get();
        $highschool_student_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 13)->get();
        $highschool_graduate_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 2)->get();
        $senior_highschool_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 14)->get();
        $als_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 15)->get();
        $college_undergraduate_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 16)->get();
        $college_graduate_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 3)->get();
        $college_student_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 17)->get();
        $post_graduate_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 4)->get();
        $vocational_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 7)->get();
        $not_applicable_non_4ps = $householdProfilingReportService->get_household_profiling_education($request, 'non-4ps', 6)->get();

        //Civil Status
        $single = $householdProfilingReportService->get_household_profiling_civil_status($request, 'single')->get();
        $married = $householdProfilingReportService->get_household_profiling_civil_status($request, 'married')->get();
        $livein = $householdProfilingReportService->get_household_profiling_civil_status($request, 'live-in')->get();
        $widowed = $householdProfilingReportService->get_household_profiling_civil_status($request, 'widow')->get();
        $separated = $householdProfilingReportService->get_household_profiling_civil_status($request, 'separated')->get();
        $cohabit = $householdProfilingReportService->get_household_profiling_civil_status($request, 'cohabit')->get();



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

            //Philhealth Category
            'philhealth_direct_contributors' => $philhealth_direct_contributors,
            'philhealth_indirect_contributors' => $philhealth_indirect_contributors,
            'philhealth_unknown' => $philhealth_unknown,

            //Sex
            'sex_male' => $sex_male,
            'sex_female' => $sex_female,

            //Ethnicity
            'indegenous' => $indegenous,
            'non_indegenous' => $non_indegenous,

            //Educational Attainment 4PS
            'pre_school_4ps' => $pre_school_4ps,
            'elementary_undergraduate_4ps' => $elementary_undergraduate_4ps,
            'elementary_student_4ps' => $elementary_student_4ps,
            'elementary_graduate_4ps' => $elementary_graduate_4ps,
            'highschool_undergraduate_4ps' => $highschool_undergraduate_4ps,
            'highschool_student_4ps' => $highschool_student_4ps,
            'highschool_graduate_4ps' => $highschool_graduate_4ps,
            'senior_highschool_4ps' => $senior_highschool_4ps,
            'als_4ps' => $als_4ps,
            'college_undergraduate_4ps' => $college_undergraduate_4ps,
            'college_graduate_4ps' => $college_graduate_4ps,
            'college_student_4ps' => $college_student_4ps,
            'post_graduate_4ps' => $post_graduate_4ps,
            'vocational_4ps' => $vocational_4ps,
            'not_applicable_4ps' => $not_applicable_4ps,

            //Educational Attainment NON-4PS
            'pre_school_non_4ps' => $pre_school_non_4ps,
            'elementary_undergraduate_non_4ps' => $elementary_undergraduate_non_4ps,
            'elementary_student_non_4ps' => $elementary_student_non_4ps,
            'elementary_graduate_non_4ps' => $elementary_graduate_non_4ps,
            'highschool_undergraduate_non_4ps' => $highschool_undergraduate_non_4ps,
            'highschool_student_non_4ps' => $highschool_student_non_4ps,
            'highschool_graduate_non_4ps' => $highschool_graduate_non_4ps,
            'senior_highschool_non_4ps' => $senior_highschool_non_4ps,
            'als_non_4ps' => $als_non_4ps,
            'college_undergraduate_non_4ps' => $college_undergraduate_non_4ps,
            'college_graduate_non_4ps' => $college_graduate_non_4ps,
            'college_student_non_4ps' => $college_student_non_4ps,
            'post_graduate_non_4ps' => $post_graduate_non_4ps,
            'vocational_non_4ps' => $vocational_non_4ps,
            'not_applicable_non_4ps' => $not_applicable_non_4ps,

            //Civil Status
            'single' => $single,
            'maried' => $married,
            'livein' => $livein,
            'widowed' => $widowed,
            'separated' => $separated,
            'cohabit' => $cohabit,

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
