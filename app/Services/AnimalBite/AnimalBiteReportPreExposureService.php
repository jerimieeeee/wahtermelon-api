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
                        CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, consult_date) < 15 THEN
                            1
                        ELSE
                            0
                        END) AS 'less_than_15',
                    SUM(
                        CASE WHEN TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                            1
                        ELSE
                            0
                        END) AS 'greater_than_15',
                    SUM(
                        CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, consult_date) >= 15
                            OR TIMESTAMPDIFF(YEAR, birthdate, consult_date) < 15 THEN
                            1
                        ELSE
                            0
                        END) AS 'less_than_and_greater_than_15',
                    SUM(
                        CASE WHEN category_id = 1 THEN
                            1
                        ELSE
                            0
                        END) AS 'category1',
                    SUM(
                        CASE WHEN category_id = 2 THEN
                            1
                        ELSE
                            0
                        END) AS 'category2',
                    SUM(
                        CASE WHEN category_id = 3 THEN
                            1
                        ELSE
                            0
                        END) AS 'category3',
                    SUM(
                        CASE WHEN category_id = 2 THEN
                            1
                        ELSE
                            0
                        END) +
                    SUM(
                        CASE WHEN category_id = 3 THEN
                            1
                        ELSE
                            0
                        END) AS 'total_cat2_and_cat3',
                    SUM(
                        CASE WHEN rig_type_code = 'HRIG' THEN
                            1
                        ELSE
                            0
                        END) AS 'HRIG',
                    SUM(
                        CASE WHEN rig_type_code = 'ERIG' THEN
                            1
                        ELSE
                            0
                        END) AS 'ERIG',
                    SUM(
                        CASE WHEN animal_type_id = 1 THEN
                            1
                        ELSE
                            0
                        END) AS 'dog',
                    SUM(
                        CASE WHEN animal_type_id = '2' THEN
                            1
                        ELSE
                            0
                        END) AS 'cat',
                    SUM(
                        CASE WHEN animal_type_id IN(3,4,5) THEN
                            1
                        ELSE
                            0
                        END) AS 'others',3
                    SUM(
                        CASE WHEN patient_ab_pre_exposures.day0_date IS NOT NULL
                             AND patient_ab_pre_exposures.day7_date IS NOT NULL
                             AND patient_ab_pre_exposures.day21_date IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END) AS 'completed'
                    ")
            ->join('patient_abs', 'patient_ab_pre_exposures.patient_id', '=', 'patient_abs.patient_id')
            ->join('patient_ab_post_exposures', 'patient_abs.id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->join('patient_ab_exposures', 'patient_abs.id', '=', 'patient_ab_exposures.patient_ab_id')
            ->join('patients', 'patient_abs.patient_id', '=', 'patients.id')
            ->join('household_members', 'patient_abs.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_abs.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('household_folders.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('household_folders.barangay_code', explode(',', $request->code));
            })
            ->groupBy('barangays.code');
    }
}
