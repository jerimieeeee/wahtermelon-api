<?php

namespace App\Services\AnimalBite;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class AnimalBiteReportPreExposureService
{
    public function get_catchment_barangays()
    {
        $result = DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code
                    ')
            ->whereFacilityCode(auth()->user()->facility_code);

        return $result->pluck('barangay_code');
    }

    public function get_ab_pre_exp_prophylaxis($request)
    {
        return DB::table('patient_ab_pre_exposures')
            ->selectRaw("
                    barangays.code,
                    barangays.name,
                    SUM(
                        CASE WHEN patients.gender = 'M' THEN
                            1
                        ELSE
                            0
                        END) AS 'male',
                    SUM(
                        CASE WHEN patients.gender = 'F' THEN
                            1
                        ELSE
                            0
                        END) AS 'female',
                    SUM(
                        CASE WHEN gender IN('M', 'F') THEN
                            1
                        ELSE
                            0
                        END) AS 'male_female_total',
                    SUM(
                        CASE WHEN (TIMESTAMPDIFF(YEAR, birthdate, day0_date) < 15) THEN
                            1
                        ELSE
                            0
                        END) AS 'less_than_15',
                    SUM(
                        CASE WHEN (TIMESTAMPDIFF(YEAR, birthdate, day0_date) >= 15) THEN
                            1
                        ELSE
                            0
                        END) AS 'greater_than_15',
                    SUM(
                        CASE WHEN (TIMESTAMPDIFF(YEAR, birthdate, day0_date) >= 15)
                            OR(TIMESTAMPDIFF(YEAR, birthdate, day0_date) < 15) THEN
                            1
                        ELSE
                            0
                        END) AS 'less_than_and_greater_than_15',
                    SUM(
                        CASE WHEN day0_date IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END) AS 'day0',
                    SUM(
                        CASE WHEN day0_date IS NOT NULL
                            AND day7_date IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END) AS 'day0_day7',
                    SUM(
                        CASE WHEN day0_date IS NOT NULL
                            AND day7_date IS NOT NULL
                            AND day21_date IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END) AS 'day0_day7_day21',
                    SUM(
                        CASE WHEN day0_date IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END) + SUM(
                        CASE WHEN day0_date IS NOT NULL
                            AND day7_date IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END) + SUM(
                        CASE WHEN day0_date IS NOT NULL
                            AND day7_date IS NOT NULL
                            AND day21_date IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END) AS 'day0_day7_day21_total'
                    ")
            ->join('patients', 'patient_ab_pre_exposures.patient_id', '=', 'patients.id')
            ->join('household_members', 'patient_ab_pre_exposures.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->whereNull('patient_ab_pre_exposures.deleted_at')
            ->whereBetween(DB::raw('DATE(day0_date)'), [$request->start_date, $request->end_date])
            ->where('patient_ab_pre_exposures.facility_code', auth()->user()->facility_code)
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('household_folders.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('household_folders.barangay_code', explode(',', $request->code));
            })
            ->groupBy('barangays.name');
    }
}
