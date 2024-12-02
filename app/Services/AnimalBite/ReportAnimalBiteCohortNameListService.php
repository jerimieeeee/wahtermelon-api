<?php

namespace App\Services\AnimalBite;

use Illuminate\Support\Facades\DB;

class ReportAnimalBiteCohortNameListService
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

    public function get_all_brgy_municipalities_patient()
    {
        return DB::table('municipalities')
            ->selectRaw("
                        patient_id,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
    }

    public function get_report_namelist($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        patient_ab_exposures.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        birthdate,
                        exposure_date AS date_of_service
                        ")
            ->join('patient_ab_post_exposures', 'patient_ab_exposures.patient_ab_id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->join('patient_abs', 'patient_ab_post_exposures.patient_ab_id', '=', 'patient_abs.id')
            ->join('patients', 'patient_ab_exposures.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_ab_exposures.patient_id');
            })
            ->whereNull('patient_ab_exposures.deleted_at')
            // total for cat2, cat3, and both
            ->when($request->params == 'total_cat2', function ($query) use ($request) {
                $query->where('category_id', 2);
            })
            ->when($request->params == 'total_cat3', function ($query) use ($request) {
                $query->where('category_id', 3);
            })
            ->when($request->params == 'total_cat2_and_cat3', function ($query) use ($request) {
                $query->whereIn('category_id', [2, 3]);
            })
            // total with rig for cat2, cat3, and both
            ->when($request->params == 'total_cat2_with_rig', function ($query) use ($request) {
                $query->where('category_id', 2)
                    ->whereIn('rig_type_code', ['ERIG', 'HRIG']);
            })
            ->when($request->params == 'total_cat3_with_rig', function ($query) use ($request) {
                $query->where('category_id', 3)
                    ->whereIn('rig_type_code', ['ERIG', 'HRIG']);
            })
            ->when($request->params == 'total_cat2_and_cat3_with_rig', function ($query) use ($request) {
                $query->whereIn('category_id', [2, 3])
                    ->whereIn('rig_type_code', ['ERIG', 'HRIG']);
            })
            // total complete cat2, cat3, and both
            ->when($request->params == 'total_cat2_complete', function ($query) use ($request) {
                $query->where('category_id', 2)
                    ->whereNotNull('day0_date')
                    ->whereNotNull('day3_date')
                    ->whereNotNull('day7_date');
            })
            ->when($request->params == 'total_cat3_complete', function ($query) use ($request) {
                $query->where('category_id', 3)
                    ->whereNotNull('day0_date')
                    ->whereNotNull('day3_date')
                    ->whereNotNull('day7_date');
            })
            ->when($request->params == 'total_cat2_and_cat3_complete', function ($query) use ($request) {
                $query->where('category_id', 2)
                    ->whereNotNull('day0_date')
                    ->whereNotNull('day3_date')
                    ->whereNotNull('day7_date');
            })
            // total incomplete cat2, cat3, and both
            ->when($request->params == 'total_cat2_incomplete', function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('category_id', 2)
                        ->where(function($query) use ($request) {
                            $query->whereNull('day0_date')
                                ->orWhereNull('day3_date')
                                ->orWhereNull('day7_date');
                        });
                });
            })
            ->when($request->params == 'total_cat3_incomplete', function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('category_id', 3)
                        ->where(function($query) use ($request) {
                            $query->whereNull('day0_date')
                                ->orWhereNull('day3_date')
                                ->orWhereNull('day7_date');
                        });
                });
            })
            ->when($request->params == 'total_cat2_and_cat3_incomplete', function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereIn('category_id', [2, 3])
                        ->where(function ($query) use ($request) {
                            $query->whereNull('day0_date')
                                ->orWhereNull('day3_date')
                                ->orWhereNull('day7_date');
                        });
                });
            })
            // total none cat2, cat3, and both
            ->when($request->params == 'total_cat2_none', function ($query) use ($request) {
                $query->where('category_id', 2)
                    ->whereNull('day0_date')
                    ->whereNull('day3_date')
                    ->whereNull('day7_date');
            })
            ->when($request->params == 'total_cat3_none', function ($query) use ($request) {
                $query->where('category_id', 3)
                    ->whereNull('day0_date')
                    ->whereNull('day3_date')
                    ->whereNull('day7_date');
            })
            ->when($request->params == 'total_cat2_and_cat3_none', function ($query) use ($request) {
                $query->whereIn('category_id', [2, 3])
                    ->whereNull('day0_date')
                    ->whereNull('day3_date')
                    ->whereNull('day7_date');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_ab_exposures.facility_code', auth()->user()->facility_code);
            })
            ->whereBetween(DB::raw('DATE(exposure_date)'), [$request->start_date, $request->end_date])
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_ab_exposures.patient_id');
            })
            ->groupBy('patient_ab_exposures.patient_id')
            ->orderBy('name');
    }
}
