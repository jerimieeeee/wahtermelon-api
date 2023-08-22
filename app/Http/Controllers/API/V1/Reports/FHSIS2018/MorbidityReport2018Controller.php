<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Morbidity\MorbidityReportService;
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
    public function index(Request $request, MorbidityReportService $morbidityReportService)
    {
        $ageGroups = [
            'total' => [
                'Male' => $morbidityReportService->get_morbidity_report_all_gender($request, 'M')->orderBy('count', 'desc')->get(),
                'Female' => $morbidityReportService->get_morbidity_report_all_gender($request, 'F')->orderBy('count', 'desc')->get(),
            ],

            'age_0_to_6_days' => [
                'Male' => $morbidityReportService->get_morbidity_report_age_days($request, 'M', 0, 6)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_age_days($request, 'F', 0, 6)->get(),
            ],
            'age_7_to_28_days' => [
                'Male' => $morbidityReportService->get_morbidity_report_age_days($request, 'M', 7, 28)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_age_days($request, 'F', 7, 28)->get(),
            ],
            'age_29_days_to_11_months' => [
                'Male' => $morbidityReportService->get_morbidity_report_age_days_and_month($request, 'M', 29, 1, 11)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_age_days_and_month($request, 'M', 29, 1, 11)->get(),
            ],
            'age_1_to_4_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 1, 4)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 1, 4)->get(),
            ],
            'age_5_to_9_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 5, 9)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 5, 9)->get(),
            ],
            'age_10_to_14_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 10, 14)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 10, 14)->get(),
            ],
            'age_15_to_19_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 15, 19)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 15, 19)->get(),
            ],
            'age_20_to_24_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 20, 24)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 20, 24)->get(),
            ],
            'age_25_to_29_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 25, 29)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 25, 29)->get(),
            ],
            'age_30_to_34_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 30, 34)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 30, 34)->get(),
            ],
            'age_35_to_39_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 35, 39)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 35, 39)->get(),
            ],
            'age_40_to_44_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 40, 44)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 40, 44)->get(),
            ],
            'age_45_to_49_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 45, 49)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 45, 49)->get(),
            ],
            'age_50_to_54_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 50, 54)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 50, 54)->get(),
            ],
            'age_55_to_59_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 55, 59)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 55, 59)->get(),
            ],
            'age_60_to_64_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 60, 64)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 60, 64)->get(),
            ],
            'age_65_to_69_years' => [
                'Male' => $morbidityReportService->get_morbidity_report_year($request, 'M', 65, 69)->get(),
                'Female' => $morbidityReportService->get_morbidity_report_year($request, 'F', 65, 69)->get(),
            ],
            'age_70_years_above' => [
                'Male' => $morbidityReportService->get_morbidity_report_70_years_above($request, 'M')->get(),
                'Female' => $morbidityReportService->get_morbidity_report_70_years_above($request, 'F')->get(),
            ],
        ];

        $result = [];

        // Loop through all age groups and initialize them in the result array
        foreach ($ageGroups as $ageGroupName => $ageGroupData) {
            foreach ($ageGroupData as $gender => $data) {
                $genderKey = strtolower($gender);
                $ageGroupKey = str_replace('age_', '', $ageGroupName);
                $newKey = $genderKey . '_age_' . $ageGroupKey;

                foreach ($data as $group) {
                    $icd10Desc = $group->icd10_desc; // Fetch the ICD-10 description from the object

                    // Initialize empty data if there's no actual data available
                    if (!isset($result[$icd10Desc])) {
                        $result[$icd10Desc] = [];
                    }

                    // Initialize empty data for the current age group if there's no actual data available
                    if (!isset($result[$icd10Desc][$newKey])) {
                        $result[$icd10Desc][$newKey] = [];
                    }

                    // Add the actual data to the result array
                    $result[$icd10Desc][$newKey][] = (array)$group; // Convert object to array
                }
            }
        }

        // Add empty data for missing age groups and genders
        foreach ($result as $icd10Desc => $ageGroupData) {
            foreach ($ageGroups as $ageGroupName => $ageGroupData) {
                foreach ($ageGroupData as $gender => $data) {
                    $genderKey = strtolower($gender);
                    $ageGroupKey = str_replace('age_', '', $ageGroupName);
                    $newKey = $genderKey . '_age_' . $ageGroupKey;

                    if (!isset($result[$icd10Desc][$newKey])) {
                        $result[$icd10Desc][$newKey] = [
                            [

                            ]
                        ];
                    }
                }
            }
        }

        // Sort the $result array based on the highest count of data entries inside each index
        uasort($result, function ($data1, $data2) {
            $count1 = 0;
            $count2 = 0;

            foreach ($data1 as $ageGroupData) {
                foreach ($ageGroupData as $genderData) {
                    $count1 += count($genderData);
                }
            }

            foreach ($data2 as $ageGroupData) {
                foreach ($ageGroupData as $genderData) {
                    $count2 += count($genderData);
                }
            }

            return $count2 - $count1;
        });

        return $result;
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
