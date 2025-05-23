<?php

namespace App\Services\AnimalBite;

use App\Models\V1\Barangay\SettingsCatchmentBarangay;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class AnimalBiteReportPreExposureNameListService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_ab_pre_exp_prophylaxis_name_list($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        provinces.psgc_10_digit_code AS province_code,
            	        municipalities.psgc_10_digit_code AS municipality_code,
	                    barangays.psgc_10_digit_code AS barangay_code,
	                    barangays.name AS barangay_name,
	                    municipalities.name AS municipality_name,
                        patient_abs.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ', ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service
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
            ->join('users', 'patient_ab_exposures.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_ab_exposures.patient_id');
            })
            ->when(in_array(auth()->user()->reports_flag, [0, 1, NULL]), function ($q) use ($request) {
                $catchment = SettingsCatchmentBarangay::query()
                    ->whereFacilityCode(auth()->user()->facility_code)
                    ->where('year', $request->year);
                $q->leftJoinSub($catchment, 'settings_catchment_barangays', function(JoinClause $join) {
                    $join->on('settings_catchment_barangays.barangay_code', '=', 'household_folders.barangay_code');
                });
            })
            ->when((auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('settings_catchment_barangays.barangay_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('municipalities.psgc_10_digit_code', $request->code);
                    });
            })
            ->when((auth()->user()->reports_flag == 1), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('municipalities.psgc_10_digit_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('provinces.psgc_10_digit_code', $request->code);
                    });
            })
            ->when($request->indicator == 'male', function ($q) use ($request) {
                $q->where('patients.gender', 'M');
            })
            ->when($request->indicator == 'female', function ($q) use ($request) {
                $q->where('patients.gender', 'F');
            })
            ->when($request->indicator == 'male_female_total', function ($q) use ($request) {
                $q->whereIn('patients.gender', ['M', 'F']);
            })
            ->when($request->indicator == 'less_than_15', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) < 15");
            })
            ->when($request->indicator == 'greater_than_15', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 15");
            })
            ->when($request->indicator == 'less_than_and_greater_than_15', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 0");
            })
            ->when($request->indicator == 'category1', function ($q) use ($request) {
                $q->where('patient_ab_exposures.category_id', 1);
            })
            ->when($request->indicator == 'category2', function ($q) use ($request) {
                $q->where('patient_ab_exposures.category_id', 2);
            })
            ->when($request->indicator == 'category3', function ($q) use ($request) {
                $q->where('patient_ab_exposures.category_id', 3);
            })
            ->when($request->indicator == 'total_cat2_and_cat3', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.category_id', [2, 3]);
            })
            ->when($request->indicator == 'total_cat1_cat2_cat3', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.category_id', [1, 2, 3]);
            })
            ->when($request->indicator == 'prep_total', function ($q) use ($request) {
                $q->selectRaw("COUNT(patient_ab_pre_exposures.patient_id) as prep_total");
            })
            ->when($request->indicator == 'prep_completed', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_pre_exposures.day0_date')
                    ->whereNotNull('patient_ab_pre_exposures.day7_date')
                    ->whereNotNull('patient_ab_pre_exposures.day21_date');
            })
            ->when($request->indicator == 'tandok', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_exposures.tandok_name');
            })
            ->when($request->indicator == 'pep_completed', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_post_exposures.day0_date')
                    ->whereNotNull('patient_ab_post_exposures.day3_date')
                    ->whereNotNull('patient_ab_post_exposures.day7_date');
            })
            ->when($request->indicator == 'tcv', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_post_exposures.day0_date');
            })
            ->when($request->indicator == 'HRIG', function ($q) use ($request) {
                $q->where('patient_ab_post_exposures.rig_type_code', 'HRIG');
            })
            ->when($request->indicator == 'ERIG', function ($q) use ($request) {
                $q->where('patient_ab_post_exposures.rig_type_code', 'ERIG');
            })
            ->when($request->indicator == 'dog', function ($q) use ($request) {
                $q->where('patient_ab_exposures.animal_type_id', 1);
            })
            ->when($request->indicator == 'cat', function ($q) use ($request) {
                $q->where('patient_ab_exposures.animal_type_id', 2);
            })
            ->when($request->indicator == 'others', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.animal_type_id', [3, 4, 5]);
            })
            ->when($request->indicator == 'total_biting_animal', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.animal_type_id', [1, 2, 3, 4, 5]);
            })
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
            });
    }

    public function get_ab_pre_exp_prophylaxis_others($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        provinces.psgc_10_digit_code AS province_code,
            	        municipalities.psgc_10_digit_code AS municipality_code,
	                    barangays.psgc_10_digit_code AS barangay_code,
	                    barangays.name AS barangay_name,
	                    municipalities.name AS municipality_name,
                        patient_abs.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ', ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service
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
            ->join('users', 'patient_abs.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_abs.patient_id');
            })
            ->when(in_array(auth()->user()->reports_flag, [0, 1, NULL]), function ($q) use ($request) {
                $catchment = SettingsCatchmentBarangay::query()
                    ->whereFacilityCode(auth()->user()->facility_code)
                    ->where('year', $request->year);
                $q->leftJoinSub($catchment, 'settings_catchment_barangays', function(JoinClause $join) {
                    $join->on('settings_catchment_barangays.barangay_code', '=', 'household_folders.barangay_code');
                });
            })
            ->when((auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('settings_catchment_barangays.barangay_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('municipalities.psgc_10_digit_code', $request->code);
                    });
            })
            ->when((auth()->user()->reports_flag == 1), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('municipalities.psgc_10_digit_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('provinces.psgc_10_digit_code', $request->code);
                    });
            })
            ->when($request->indicator == 'male', function ($q) use ($request) {
                $q->where('patients.gender', 'M');
            })
            ->when($request->indicator == 'female', function ($q) use ($request) {
                $q->where('patients.gender', 'F');
            })
            ->when($request->indicator == 'male_female_total', function ($q) use ($request) {
                $q->whereIn('patients.gender', ['M', 'F']);
            })
            ->when($request->indicator == 'less_than_15', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) < 15");
            })
            ->when($request->indicator == 'greater_than_15', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 15");
            })
            ->when($request->indicator == 'less_than_and_greater_than_15', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 0");
            })
            ->when($request->indicator == 'category1', function ($q) use ($request) {
                $q->where('patient_ab_exposures.category_id', 1);
            })
            ->when($request->indicator == 'category2', function ($q) use ($request) {
                $q->where('patient_ab_exposures.category_id', 2);
            })
            ->when($request->indicator == 'category3', function ($q) use ($request) {
                $q->where('patient_ab_exposures.category_id', 3);
            })
            ->when($request->indicator == 'total_cat2_and_cat3', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.category_id', [2, 3]);
            })
            ->when($request->indicator == 'total_cat1_cat2_cat3', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.category_id', [1, 2, 3]);
            })
            ->when($request->indicator == 'prep_total', function ($q) use ($request) {
                $q->selectRaw("COUNT(patient_ab_pre_exposures.patient_id) as prep_total");
            })
            ->when($request->indicator == 'prep_completed', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_pre_exposures.day0_date')
                    ->whereNotNull('patient_ab_pre_exposures.day7_date')
                    ->whereNotNull('patient_ab_pre_exposures.day21_date');
            })
            ->when($request->indicator == 'tandok', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_exposures.tandok_name');
            })
            ->when($request->indicator == 'pep_completed', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_post_exposures.day0_date')
                    ->whereNotNull('patient_ab_post_exposures.day3_date')
                    ->whereNotNull('patient_ab_post_exposures.day7_date');
            })
            ->when($request->indicator == 'tcv', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_post_exposures.day0_date');
            })
            ->when($request->indicator == 'HRIG', function ($q) use ($request) {
                $q->where('patient_ab_post_exposures.rig_type_code', 'HRIG');
            })
            ->when($request->indicator == 'ERIG', function ($q) use ($request) {
                $q->where('patient_ab_post_exposures.rig_type_code', 'ERIG');
            })
            ->when($request->indicator == 'dog', function ($q) use ($request) {
                $q->where('patient_ab_exposures.animal_type_id', 1);
            })
            ->when($request->indicator == 'cat', function ($q) use ($request) {
                $q->where('patient_ab_exposures.animal_type_id', 2);
            })
            ->when($request->indicator == 'others', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.animal_type_id', [3, 4, 5]);
            })
            ->when($request->indicator == 'total_biting_animal', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.animal_type_id', [1, 2, 3, 4, 5]);
            })
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
            });
    }

    public function get_previous_quarter_cat2_cat3($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        provinces.psgc_10_digit_code AS province_code,
            	        municipalities.psgc_10_digit_code AS municipality_code,
	                    barangays.psgc_10_digit_code AS barangay_code,
	                    barangays.name AS barangay_name,
	                    municipalities.name AS municipality_name,
                        patient_abs.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ', ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service
                    ")
            ->join('patient_abs', 'patient_ab_exposures.patient_ab_id', '=', 'patient_abs.id')
            ->join('patients', 'patient_ab_exposures.patient_id', '=', 'patients.id')
            ->leftJoin('patient_ab_post_exposures', 'patient_abs.id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->join('household_members', 'patient_ab_exposures.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('users', 'patient_abs.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_abs.patient_id');
            })
            ->when(in_array(auth()->user()->reports_flag, [0, 1, NULL]), function ($q) use ($request) {
                $catchment = SettingsCatchmentBarangay::query()
                    ->whereFacilityCode(auth()->user()->facility_code)
                    ->where('year', $request->year);
                $q->leftJoinSub($catchment, 'settings_catchment_barangays', function(JoinClause $join) {
                    $join->on('settings_catchment_barangays.barangay_code', '=', 'household_folders.barangay_code');
                });
            })
            ->when((auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('settings_catchment_barangays.barangay_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('municipalities.psgc_10_digit_code', $request->code);
                    });
            })
            ->when((auth()->user()->reports_flag == 1), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('municipalities.psgc_10_digit_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('provinces.psgc_10_digit_code', $request->code);
                    });
            })
            ->when($request->indicator == 'total_cat2_and_cat3_previous_quarter', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.category_id', [2, 3]);
            })
            ->when($request->indicator == 'pep_completed_previous', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_post_exposures.day0_date')
                    ->whereNotNull('patient_ab_post_exposures.day3_date')
                    ->whereNotNull('patient_ab_post_exposures.day7_date');
            })
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
            });
    }

    public function get_previous_quarter_cat2_cat3_others($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        provinces.psgc_10_digit_code AS province_code,
            	        municipalities.psgc_10_digit_code AS municipality_code,
	                    barangays.psgc_10_digit_code AS barangay_code,
	                    barangays.name AS barangay_name,
	                    municipalities.name AS municipality_name,
                        patient_abs.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ', ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service
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
            ->join('users', 'patient_ab_exposures.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ab_exposures.facility_code', 'patient_ab_exposures.patient_id');
            })
            ->when(in_array(auth()->user()->reports_flag, [0, 1, NULL]), function ($q) use ($request) {
                $catchment = SettingsCatchmentBarangay::query()
                    ->whereFacilityCode(auth()->user()->facility_code)
                    ->where('year', $request->year);
                $q->leftJoinSub($catchment, 'settings_catchment_barangays', function(JoinClause $join) {
                    $join->on('settings_catchment_barangays.barangay_code', '=', 'household_folders.barangay_code');
                });
            })
            ->when((auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('settings_catchment_barangays.barangay_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('municipalities.psgc_10_digit_code', $request->code);
                    });
            })
            ->when((auth()->user()->reports_flag == 1), function ($q) use ($request) {
                $q->when($request->type == 'catchment', function ($q) use ($request) {
                    $q->where('municipalities.psgc_10_digit_code', $request->code);
                })
                    ->when($request->type == 'non-catchment', function ($q) use ($request) {
                        $q->where('provinces.psgc_10_digit_code', $request->code);
                    });
            })
            ->when($request->indicator == 'total_cat2_and_cat3_previous_quarter', function ($q) use ($request) {
                $q->whereIn('patient_ab_exposures.category_id', [2, 3]);
            })
            ->when($request->indicator == 'pep_completed_previous', function ($q) use ($request) {
                $q->whereNotNull('patient_ab_post_exposures.day0_date')
                    ->whereNotNull('patient_ab_post_exposures.day3_date')
                    ->whereNotNull('patient_ab_post_exposures.day7_date');
            })
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
            });
    }
}
