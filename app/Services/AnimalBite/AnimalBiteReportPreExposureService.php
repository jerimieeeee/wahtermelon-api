<?php

namespace App\Services\AnimalBite;

use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Support\Facades\DB;

class AnimalBiteReportPreExposureService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_ab_pre_exp_prophylaxis($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        municipalities.name AS municipality_name,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.name AS barangay_name,
                        barangays.psgc_10_digit_code AS barangay_code,
                        settings_catchment_barangays.population,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M' THEN 1
                                ELSE 0
                            END
                        ) AS 'male',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F' THEN 1
                                ELSE 0
                            END
                        ) AS 'female',
                        SUM(
                            CASE
                                WHEN patients.gender IN ('M', 'F') THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_total',
                        SUM(
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) < 15 THEN 1
                                ELSE 0
                            END
                        ) AS 'less_than_15',
                        SUM(
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 15 THEN 1
                                ELSE 0
                            END
                        ) AS 'greater_than_15',
                        SUM(
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 15
                                OR TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) < 15 THEN 1
                                ELSE 0
                            END
                        ) AS 'less_than_and_greater_than_15',
                        SUM(
                            CASE
                                WHEN category_id = 1 THEN 1
                                ELSE 0
                            END
                        ) AS 'category1',
                        SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END
                        ) AS 'category2',
                        SUM(
                            CASE
                                WHEN category_id = 3 THEN 1
                                ELSE 0
                            END
                        ) AS 'category3',
                        SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN category_id = 3 THEN 1
                                ELSE 0
                            END
                        ) AS 'total_cat2_and_cat3',
                        SUM(
                            CASE
                                WHEN category_id = 1 THEN 1
                                ELSE 0
                            END)
						+ SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END)
						+ SUM(
							CASE
								WHEN category_id = 3 THEN 1
                                ELSE 0
                            END) AS total_cat1_cat2_cat3,
                        COUNT(patient_ab_pre_exposures.patient_id) AS 'prep_total',
                        SUM(
                            CASE
                                WHEN patient_ab_pre_exposures.day0_date IS NOT NULL
                                AND patient_ab_pre_exposures.day7_date IS NOT NULL
                                AND patient_ab_pre_exposures.day21_date IS NOT NULL THEN 1
                                ELSE 0
                            END
                        ) AS 'prep_completed',
                        SUM(
                            CASE
                                WHEN patient_ab_exposures.tandok_name IS NOT NULL
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'tandok',
                        SUM(
                            CASE
                                WHEN patient_ab_post_exposures.day0_date IS NOT NULL
                                AND patient_ab_post_exposures.day3_date IS NOT NULL
                                AND patient_ab_post_exposures.day7_date IS NOT NULL
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'pep_completed',
                        SUM(
                            CASE
                                WHEN patient_ab_post_exposures.day0_date IS NOT NULL
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'tcv',
                        SUM(
                            CASE
                                WHEN rig_type_code = 'HRIG' THEN 1
                                ELSE 0
                            END
                        ) AS 'HRIG',
                        SUM(
                            CASE
                                WHEN rig_type_code = 'ERIG' THEN 1
                                ELSE 0
                            END
                        ) AS 'ERIG',
                        SUM(
                            CASE
                                WHEN animal_type_id = 1 THEN 1
                                ELSE 0
                            END
                        ) AS 'dog',
                        SUM(
                            CASE
                                WHEN animal_type_id = 2 THEN 1
                                ELSE 0
                            END
                        ) AS 'cat',
                        SUM(
                            CASE
                                WHEN animal_type_id IN (3, 4, 5)
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'others',
                        SUM(
                            CASE
                                WHEN category_id = 3 THEN 1
                                ELSE 0
                            END
                        ) AS 'category3',
                        SUM(
                            CASE
                                WHEN animal_type_id = 1 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN animal_type_id = 2 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN animal_type_id IN (3, 4, 5)
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'total_biting_animal'
                    ")
            ->join('patient_abs', 'patient_ab_exposures.patient_ab_id', '=', 'patient_abs.id')
            ->leftJoin('patient_ab_pre_exposures', 'patient_ab_exposures.patient_id', '=', 'patient_ab_pre_exposures.patient_id')
            ->leftJoin('patient_ab_post_exposures', 'patient_ab_exposures.patient_ab_id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->join('patients', 'patient_ab_exposures.patient_id', '=', 'patients.id')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('settings_catchment_barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
            ->join('users', 'patient_ab_exposures.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_abs.patient_id');
            })
            ->whereIn('settings_catchment_barangays.barangay_code', $this->categoryFilterService->get_catchment_barangays())
            ->where('settings_catchment_barangays.year', $request->year)
            ->when($request->quarter == 1, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-01-01", // January 1st of the requested year
                    "{$request->year}-03-31"  // March 31st of the requested year
                ]);
            })
            ->when($request->quarter == 2, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-04-01", // April 1st of the requested year
                    "{$request->year}-06-30"  // June 30th of the requested year
                ]);
            })
            ->when($request->quarter == 3, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-07-01", // July 1st of the requested year
                    "{$request->year}-09-30"  // September 30th of the requested year
                ]);
            })
            ->when($request->quarter == 4, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-10-01", // October 1st of the requested year
                    "{$request->year}-12-31"  // December 31st of the requested year
                ]);
            })
            ->when((auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL), function ($q) {
                $q->groupBy('barangays.psgc_10_digit_code');
            })
            ->groupBy('municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_ab_pre_exp_prophylaxis_others($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        municipalities.name AS municipality_name,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.name AS barangay_name,
                        barangays.psgc_10_digit_code AS barangay_code,
                        settings_catchment_barangays.population,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M' THEN 1
                                ELSE 0
                            END
                        ) AS 'male',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F' THEN 1
                                ELSE 0
                            END
                        ) AS 'female',
                        SUM(
                            CASE
                                WHEN patients.gender IN ('M', 'F') THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_total',
                        SUM(
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) < 15 THEN 1
                                ELSE 0
                            END
                        ) AS 'less_than_15',
                        SUM(
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 15 THEN 1
                                ELSE 0
                            END
                        ) AS 'greater_than_15',
                        SUM(
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 15
                                OR TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) < 15 THEN 1
                                ELSE 0
                            END
                        ) AS 'less_than_and_greater_than_15',
                        SUM(
                            CASE
                                WHEN category_id = 1 THEN 1
                                ELSE 0
                            END
                        ) AS 'category1',
                        SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END
                        ) AS 'category2',
                        SUM(
                            CASE
                                WHEN category_id = 3 THEN 1
                                ELSE 0
                            END
                        ) AS 'category3',
                        SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN category_id = 3 THEN 1
                                ELSE 0
                            END
                        ) AS 'total_cat2_and_cat3',
                        SUM(
                            CASE
                                WHEN category_id = 1 THEN 1
                                ELSE 0
                            END)
						+ SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END)
						+ SUM(
							CASE
								WHEN category_id = 3 THEN 1
                                ELSE 0
                            END) AS total_cat1_cat2_cat3,
                        COUNT(patient_ab_pre_exposures.patient_id) AS 'prep_total',
                        SUM(
                            CASE
                                WHEN patient_ab_pre_exposures.day0_date IS NOT NULL
                                AND patient_ab_pre_exposures.day7_date IS NOT NULL
                                AND patient_ab_pre_exposures.day21_date IS NOT NULL THEN 1
                                ELSE 0
                            END
                        ) AS 'prep_completed',
                        SUM(
                            CASE
                                WHEN patient_ab_exposures.tandok_name IS NOT NULL
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'tandok',
                        SUM(
                            CASE
                                WHEN patient_ab_post_exposures.day0_date IS NOT NULL
                                AND patient_ab_post_exposures.day3_date IS NOT NULL
                                AND patient_ab_post_exposures.day7_date IS NOT NULL
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'pep_completed',
                        SUM(
                            CASE
                                WHEN patient_ab_post_exposures.day0_date IS NOT NULL
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'tcv',
                        SUM(
                            CASE
                                WHEN rig_type_code = 'HRIG' THEN 1
                                ELSE 0
                            END
                        ) AS 'HRIG',
                        SUM(
                            CASE
                                WHEN rig_type_code = 'ERIG' THEN 1
                                ELSE 0
                            END
                        ) AS 'ERIG',
                        SUM(
                            CASE
                                WHEN animal_type_id = 1 THEN 1
                                ELSE 0
                            END
                        ) AS 'dog',
                        SUM(
                            CASE
                                WHEN animal_type_id = 2 THEN 1
                                ELSE 0
                            END
                        ) AS 'cat',
                        SUM(
                            CASE
                                WHEN animal_type_id IN (3, 4, 5)
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'others',
                        SUM(
                            CASE
                                WHEN animal_type_id = 1 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN animal_type_id = 2 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN animal_type_id IN (3, 4, 5)
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'total_biting_animal'
                    ")
            ->join('patient_abs', 'patient_ab_exposures.patient_ab_id', '=', 'patient_abs.id')
            ->leftJoin('patient_ab_pre_exposures', 'patient_ab_exposures.patient_id', '=', 'patient_ab_pre_exposures.patient_id')
            ->leftJoin('patient_ab_post_exposures', 'patient_ab_exposures.patient_ab_id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->join('patients', 'patient_ab_exposures.patient_id', '=', 'patients.id')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('settings_catchment_barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
            ->join('users', 'patient_abs.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_abs.patient_id');
            })
            ->whereNotIn('settings_catchment_barangays.barangay_code', $this->categoryFilterService->get_catchment_barangays())
            ->where('settings_catchment_barangays.year', $request->year)
            ->when($request->quarter == 1, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-01-01", // January 1st of the requested year
                    "{$request->year}-03-31"  // March 31st of the requested year
                ]);
            })
            ->when($request->quarter == 2, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-04-01", // April 1st of the requested year
                    "{$request->year}-06-30"  // June 30th of the requested year
                ]);
            })
            ->when($request->quarter == 3, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-07-01", // July 1st of the requested year
                    "{$request->year}-09-30"  // September 30th of the requested year
                ]);
            })
            ->when($request->quarter == 4, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-10-01", // October 1st of the requested year
                    "{$request->year}-12-31"  // December 31st of the requested year
                ]);
            })
            ->when((auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL), function ($q) {
                $q->groupBy('barangays.psgc_10_digit_code');
            })
            ->groupBy('municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_previous_quarter_cat2_cat3($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        municipalities.name AS municipality_name,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.name AS barangay_name,
                        barangays.psgc_10_digit_code AS barangay_code,
                        barangays.name AS barangay_name,
                        SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN category_id = 3 THEN 1
                                ELSE 0
                            END
                        ) AS 'total_cat2_and_cat3_previous_quarter'
                    ")
            ->join('patient_abs', 'patient_ab_exposures.patient_ab_id', '=', 'patient_abs.id')
            ->join('patients', 'patient_ab_exposures.patient_id', '=', 'patients.id')
            ->join('household_members', 'patient_ab_exposures.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('settings_catchment_barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
            ->join('users', 'patient_abs.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_abs.patient_id');
            })
            ->whereIn('settings_catchment_barangays.barangay_code', $this->categoryFilterService->get_catchment_barangays())
            ->where('settings_catchment_barangays.year', $request->year)
            ->when($request->quarter == 1, function ($q) use ($request) {
                $previousYear = $request->year - 1;  // Calculate the previous year
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$previousYear}-10-01", // October 1st of the previous year
                    "{$previousYear}-12-31"  // December 31st of the previous year
                ]);
            })
            ->when($request->quarter == 2, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-01-01", // January 1st of the requested year
                    "{$request->year}-03-31"  // March 31st of the requested year
                ]);
            })
            ->when($request->quarter == 3, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-04-01", // April 1st of the requested year
                    "{$request->year}-06-30"  // June 30th of the requested year
                ]);
            })
            ->when($request->quarter == 4, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-07-01", // July 1st of the requested year
                    "{$request->year}-09-30"  // September 30th of the requested year
                ]);
            })
            ->groupBy('municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_previous_quarter_cat2_cat3_others($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        municipalities.name AS municipality_name,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.name AS barangay_name,
                        barangays.psgc_10_digit_code AS barangay_code,
                        barangays.name AS barangay_name,
                        SUM(
                            CASE
                                WHEN category_id = 2 THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN category_id = 3 THEN 1
                                ELSE 0
                            END
                        ) AS 'total_cat2_and_cat3_previous_quarter'
                    ")
            ->join('patient_abs', 'patient_ab_exposures.patient_ab_id', '=', 'patient_abs.id')
            ->join('patients', 'patient_ab_exposures.patient_id', '=', 'patients.id')
            ->join('household_members', 'patient_ab_exposures.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('settings_catchment_barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
            ->join('users', 'patient_ab_exposures.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_abs.patient_id');
            })
            ->whereIn('settings_catchment_barangays.barangay_code', $this->categoryFilterService->get_catchment_barangays())
            ->where('settings_catchment_barangays.year', $request->year)
            ->whereNull('patient_ab_exposures.deleted_at')
            ->when($request->quarter == 1, function ($q) use ($request) {
                $previousYear = $request->year - 1;  // Calculate the previous year
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$previousYear}-10-01", // October 1st of the previous year
                    "{$previousYear}-12-31"  // December 31st of the previous year
                ]);
            })
            ->when($request->quarter == 2, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-01-01", // January 1st of the requested year
                    "{$request->year}-03-31"  // March 31st of the requested year
                ]);
            })
            ->when($request->quarter == 3, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-04-01", // April 1st of the requested year
                    "{$request->year}-06-30"  // June 30th of the requested year
                ]);
            })
            ->when($request->quarter == 4, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(consult_date)'), [
                    "{$request->year}-07-01", // July 1st of the requested year
                    "{$request->year}-09-30"  // September 30th of the requested year
                ]);
            })
            ->groupBy('municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }
}
