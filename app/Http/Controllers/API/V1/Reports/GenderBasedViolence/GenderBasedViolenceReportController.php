<?php

namespace App\Http\Controllers\API\V1\Reports\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Services\GenderBasedViolence\GenderBasedViolenceReportService;
use Illuminate\Http\Request;

class GenderBasedViolenceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GenderBasedViolenceReportService $genderBasedViolenceReportService)
    {
        //SEXUAL ABUSE
        $female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_report_sexual_abuse($request, 'F', '0', '5')
            ->selectRaw("IF(same_address_flag = 1, barangays.name, barangays.name) AS barangay_name")
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_report_sexual_abuse($request, 'F', '6', '9')
            ->selectRaw("IF(same_address_flag = 1, barangays.name, barangays.name) AS barangay_name")
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_report_sexual_abuse($request, 'F', '10', '17')
            ->selectRaw("IF(same_address_flag = 1, barangays.name, barangays.name) AS barangay_name")
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_report_sexual_abuse($request, 'F', '18', '19')
            ->selectRaw("IF(same_address_flag = 1, barangays.name, barangays.name) AS barangay_name")
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_report_sexual_abuse($request, 'F', '20', '59')
            ->selectRaw("IF(same_address_flag = 1, barangays.name, barangays.name) AS barangay_name")
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_report_sexual_abuse($request, 'F', '60', '200')
            ->selectRaw("IF(same_address_flag = 1, barangays.name, barangays.name) AS barangay_name")
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');



        return [

            // FEMALE AGE 18 TO 19
            'sexual_abuse' => ['female_age_0_to_5' => $female_age_0_to_5,
                               'female_age_6_to_9' => $female_age_6_to_9,
                               'female_age_10_to_17' => $female_age_10_to_17,
                               'female_age_18_to_19' => $female_age_18_to_19,
                               'female_age_20_to_59' => $female_age_20_to_59,
                               'female_age_60_and_above' => $female_age_60_and_above
                            ],
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
