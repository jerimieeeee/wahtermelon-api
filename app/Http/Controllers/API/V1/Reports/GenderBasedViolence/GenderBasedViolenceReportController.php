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
        $female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_report($request, 'F', '0', '5')
            ->selectRaw("IF(same_address_flag = 1, barangay_code, intake_barangay_code) AS barangay_code")
            ->get()
            ->pluck(null, 'barangay_name');

        $female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_report($request, 'F', '6', '9')
            ->selectRaw("IF(same_address_flag = 1, barangay_code, intake_barangay_code) AS barangay_code")
            ->get()
            ->pluck(null, 'barangay_name');

        $female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_report($request, 'F', '10', '17')
            ->selectRaw("IF(same_address_flag = 1, barangay_code, intake_barangay_code) AS barangay_code")
            ->get()
            ->pluck(null, 'barangay_name');

        $female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_report($request, 'F', '18', '19')
            ->selectRaw("IF(same_address_flag = 1, barangay_code, intake_barangay_code) AS barangay_code")
            ->get()
            ->pluck(null, 'barangay_name');

        return [
            // FEMALE AGE 0 TO 5
            'Female_age_0_to_5' => $female_age_0_to_5,

            // FEMALE AGE 6 TO 9
            'Female_age_6_to_9' => $female_age_6_to_9,

            // FEMALE AGE 10 TO 17
            'Female_age_10_to_17' => $female_age_10_to_17,

            // FEMALE AGE 18 TO 19
            'Female_age_18_to_19' => $female_age_18_to_19,
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
