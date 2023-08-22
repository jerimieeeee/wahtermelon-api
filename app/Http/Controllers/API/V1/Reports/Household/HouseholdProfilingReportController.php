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

        //Religion
        $roman_catholic = $householdProfilingReportService->get_household_profiling_religion($request, 'roman-catholic')->get();
        $christian = $householdProfilingReportService->get_household_profiling_religion($request, 'christian')->get();
        $iglesianicirsto = $householdProfilingReportService->get_household_profiling_religion($request, 'inc')->get();
        $catholic = $householdProfilingReportService->get_household_profiling_religion($request, 'catholic')->get();
        $islam = $householdProfilingReportService->get_household_profiling_religion($request, 'islam')->get();
        $baptist = $householdProfilingReportService->get_household_profiling_religion($request, 'baptist')->get();
        $bornagain = $householdProfilingReportService->get_household_profiling_religion($request, 'bornagain')->get();
        $buddhist = $householdProfilingReportService->get_household_profiling_religion($request, 'buddist')->get();
        $churchofgod = $householdProfilingReportService->get_household_profiling_religion($request, 'churchofgod')->get();
        $jehovah = $householdProfilingReportService->get_household_profiling_religion($request, 'jehovah')->get();
        $protestant = $householdProfilingReportService->get_household_profiling_religion($request, 'protestant')->get();
        $seventhday = $householdProfilingReportService->get_household_profiling_religion($request, 'seventhday')->get();
        $mormons = $householdProfilingReportService->get_household_profiling_religion($request, 'mormons')->get();
        $evangelical = $householdProfilingReportService->get_household_profiling_religion($request, 'evangelical')->get();
        $pentecostal = $householdProfilingReportService->get_household_profiling_religion($request, 'pentecostal')->get();
        $unknown = $householdProfilingReportService->get_household_profiling_religion($request, 'unknown')->get();
        $others = $householdProfilingReportService->get_household_profiling_religion($request, 'others')->get();

        //Medical History Male
        $hypertension_male = $householdProfilingReportService->get_household_profiling_medical_history($request, 'hypertension', 'M')->get();
        $diabetes_male = $householdProfilingReportService->get_household_profiling_medical_history($request, 'diabetes', 'M')->get();
        $tb_male = $householdProfilingReportService->get_household_profiling_medical_history($request, 'tb', 'M')->get();
        $others_male = $householdProfilingReportService->get_household_profiling_medical_history($request, 'others', 'M')->get();

        //Medical History Female
        $hypertension_female = $householdProfilingReportService->get_household_profiling_medical_history($request, 'hypertension', 'F')->get();
        $diabetes_female = $householdProfilingReportService->get_household_profiling_medical_history($request, 'diabetes', 'F')->get();
        $tb_female = $householdProfilingReportService->get_household_profiling_medical_history($request, 'tb', 'F')->get();
        $others_female = $householdProfilingReportService->get_household_profiling_medical_history($request, 'others', 'F')->get();

        //Age Group Male
        $age_1_to_28_days_male = $householdProfilingReportService->get_household_profiling_age_group($request, '1-28days', 'M')->get();
        $age_29_days_to_11_months_male = $householdProfilingReportService->get_household_profiling_age_group($request, '29-11months', 'M')->get();
        $age_1_to_4_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '1-4years', 'M')->get();
        $age_5_to_9_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '5-9years', 'M')->get();
        $age_10_to_14_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '10-14years', 'M')->get();
        $age_15_to_19_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '15-19years', 'M')->get();
        $age_20_to_24_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '20-24years', 'M')->get();
        $age_25_to_29_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '25-29years', 'M')->get();
        $age_30_to_34_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '30-34years', 'M')->get();
        $age_35_to_39_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '35-39years', 'M')->get();
        $age_40_to_44_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '40-44years', 'M')->get();
        $age_45_to_49_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '45-49years', 'M')->get();
        $age_50_to_54_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '50-54years', 'M')->get();
        $age_55_to_59_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '55-59years', 'M')->get();
        $age_60_to_64_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '60-64years', 'M')->get();
        $age_65_to_69_years_male = $householdProfilingReportService->get_household_profiling_age_group($request, '65-69years', 'M')->get();
        $age_70_years_up_male = $householdProfilingReportService->get_household_profiling_age_group($request, '70years', 'M')->get();

        //Age Group Female
        $age_1_to_28_days_female = $householdProfilingReportService->get_household_profiling_age_group($request, '1-28days', 'F')->get();
        $age_29_days_to_11_months_female = $householdProfilingReportService->get_household_profiling_age_group($request, '29-11months', 'F')->get();
        $age_1_to_4_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '1-4years', 'F')->get();
        $age_5_to_9_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '5-9years', 'F')->get();
        $age_10_to_14_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '10-14years', 'F')->get();
        $age_15_to_19_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '15-19years', 'F')->get();
        $age_20_to_24_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '20-24years', 'F')->get();
        $age_25_to_29_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '25-29years', 'F')->get();
        $age_30_to_34_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '30-34years', 'F')->get();
        $age_35_to_39_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '35-39years', 'F')->get();
        $age_40_to_44_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '40-44years', 'F')->get();
        $age_45_to_49_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '45-49years', 'F')->get();
        $age_50_to_54_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '50-54years', 'F')->get();
        $age_55_to_59_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '55-59years', 'F')->get();
        $age_60_to_64_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '60-64years', 'F')->get();
        $age_65_to_69_years_female = $householdProfilingReportService->get_household_profiling_age_group($request, '65-69years', 'F')->get();
        $age_70_years_up_female = $householdProfilingReportService->get_household_profiling_age_group($request, '70years', 'F')->get();

        //Family Planning Methods 4PS
        $family_planning_method_coc_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'coc')->get();
        $family_planning_method_pop_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'pop')->get();
        $family_planning_method_injectables_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'injectables')->get();
        $family_planning_method_iud_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'iud')->get();
        $family_planning_method_condom_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'condom')->get();
        $family_planning_method_lam_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'lam')->get();
        $family_planning_method_btl_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'btl')->get();
        $family_planning_method_implant_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'implant')->get();
        $family_planning_method_sdm_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'sdm')->get();
        $family_planning_method_vasectomy_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'vasectomy')->get();
        $family_planning_method_bbt_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'bbt')->get();
        $family_planning_method_others_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, '4ps', 'others')->get();

        //Family Planning Methods NON-4PS
        $family_planning_method_coc_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'coc')->get();
        $family_planning_method_pop_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'pop')->get();
        $family_planning_method_injectables_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'injectables')->get();
        $family_planning_method_iud_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'iud')->get();
        $family_planning_method_condom_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'condom')->get();
        $family_planning_method_lam_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'lam')->get();
        $family_planning_method_btl_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'btl')->get();
        $family_planning_method_implant_non_4ps= $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'implant')->get();
        $family_planning_method_sdm_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'sdm')->get();
        $family_planning_method_vasectomy_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'vasectomy')->get();
        $family_planning_method_bbt_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'bbt')->get();
        $family_planning_method_others_non_4ps = $householdProfilingReportService->get_household_profiling_family_planning_method($request, 'non-4ps', 'others')->get();


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

            //Civil Status
            'roman_catholic' => $roman_catholic,
            'christian' => $christian,
            'iglesianicirsto' => $iglesianicirsto,
            'catholic' => $catholic,
            'islam' => $islam,
            'baptist' => $baptist,
            'bornagain' => $bornagain,
            'buddhist' => $buddhist,
            'churchofgod' => $churchofgod,
            'jehovah' => $jehovah,
            'protestant' => $protestant,
            'seventhday' => $seventhday,
            'mormons' => $mormons,
            'evangelical' => $evangelical,
            'pentecostal' => $pentecostal,
            'unknown' => $unknown,
            'others' => $others,

            //Male Medical History
            'hypertension_male' => $hypertension_male,
            'diabetes_male' => $diabetes_male,
            'tb_male' => $tb_male,
            'others_male' => $others_male,

            //Female Medical History
            'hypertension_female' => $hypertension_female,
            'diabetes_female' => $diabetes_female,
            'tb_female' => $tb_female,
            'others_female' => $others_female,

            //Age Group Male
            'age_1_to_28_days_male' => $age_1_to_28_days_male,
            'age_29_days_to_11_months_male' => $age_29_days_to_11_months_male,
            'age_1_to_4_years_male' => $age_1_to_4_years_male,
            'age_5_to_9_years_male' => $age_5_to_9_years_male,
            'age_10_to_14_years_male' => $age_10_to_14_years_male,
            'age_15_to_19_years_male' => $age_15_to_19_years_male,
            'age_20_to_24_years_male' => $age_20_to_24_years_male,
            'age_25_to_29_years_male' => $age_25_to_29_years_male,
            'age_30_to_34_years_male' => $age_30_to_34_years_male,
            'age_35_to_39_years_male' => $age_35_to_39_years_male,
            'age_40_to_44_years_male' => $age_40_to_44_years_male,
            'age_45_to_49_years_male' => $age_45_to_49_years_male,
            'age_50_to_54_years_male' => $age_50_to_54_years_male,
            'age_55_to_59_years_male' => $age_55_to_59_years_male,
            'age_60_to_64_years_male' => $age_60_to_64_years_male,
            'age_65_to_69_years_male' => $age_65_to_69_years_male,
            'age_70_years_up_male' => $age_70_years_up_male,

            //Age Group Female
            'age_1_to_28_days_female' => $age_1_to_28_days_female,
            'age_29_days_to_11_months_female' => $age_29_days_to_11_months_female,
            'age_1_to_4_years_female' => $age_1_to_4_years_female,
            'age_5_to_9_years_female' => $age_5_to_9_years_female,
            'age_10_to_14_years_female' => $age_10_to_14_years_female,
            'age_15_to_19_years_female' => $age_15_to_19_years_female,
            'age_20_to_24_years_female' => $age_20_to_24_years_female,
            'age_25_to_29_years_female' => $age_25_to_29_years_female,
            'age_30_to_34_years_female' => $age_30_to_34_years_female,
            'age_35_to_39_years_female' => $age_35_to_39_years_female,
            'age_40_to_44_years_female' => $age_40_to_44_years_female,
            'age_45_to_49_years_female' => $age_45_to_49_years_female,
            'age_50_to_54_years_female' => $age_50_to_54_years_female,
            'age_55_to_59_years_female' => $age_55_to_59_years_female,
            'age_60_to_64_years_female' => $age_60_to_64_years_female,
            'age_65_to_69_years_female' => $age_65_to_69_years_female,
            'age_70_years_up_female' => $age_70_years_up_female,

            //Family Planning Method 4PS
            'family_planning_method_coc_4ps' => $family_planning_method_coc_4ps,
            'family_planning_method_pop_4ps' => $family_planning_method_pop_4ps,
            'family_planning_method_injectables_4ps' => $family_planning_method_injectables_4ps,
            'family_planning_method_iud_4ps' => $family_planning_method_iud_4ps,
            'family_planning_method_condom_4ps' => $family_planning_method_condom_4ps,
            'family_planning_method_lam_4ps' => $family_planning_method_lam_4ps,
            'family_planning_method_btl_4ps' => $family_planning_method_btl_4ps,
            'family_planning_method_implant_4ps' => $family_planning_method_implant_4ps,
            'family_planning_method_sdm_4ps' => $family_planning_method_sdm_4ps,
            'family_planning_method_vasectomy_4ps' => $family_planning_method_vasectomy_4ps,
            'family_planning_method_bbt_4ps' => $family_planning_method_bbt_4ps,
            'family_planning_method_others_4ps' => $family_planning_method_others_4ps,

            //Family Planning Methods NON-4PS
            'family_planning_method_coc_non_4ps' => $family_planning_method_coc_non_4ps,
            'family_planning_method_pop_non_4ps' => $family_planning_method_pop_non_4ps,
            'family_planning_method_injectables_non_4ps' => $family_planning_method_injectables_non_4ps,
            'family_planning_method_iud_non_4ps' => $family_planning_method_iud_non_4ps,
            'family_planning_method_condom_non_4ps' => $family_planning_method_condom_non_4ps,
            'family_planning_method_lam_non_4ps' => $family_planning_method_lam_non_4ps,
            'family_planning_method_btl_non_4ps' => $family_planning_method_btl_non_4ps,
            'family_planning_method_implant_non_4ps' => $family_planning_method_implant_non_4ps,
            'family_planning_method_sdm_non_4ps' => $family_planning_method_sdm_non_4ps,
            'family_planning_method_vasectomy_non_4ps' => $family_planning_method_vasectomy_non_4ps,
            'family_planning_method_bbt_non_4ps' => $family_planning_method_bbt_non_4ps,
            'family_planning_method_others_non_4ps' => $family_planning_method_others_non_4ps,

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
