<?php

namespace App\Services\AnimalBite;

use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Support\Facades\DB;

class ReportAnimalBitePreExposureNameListService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_report_namelist($request)
    {
        return DB::table('patient_ab_pre_exposures')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        day0_date AS date_of_service
                        ")
            ->join('patient_abs', 'patient_ab_pre_exposures.patient_id', '=', 'patient_abs.patient_id')
            ->lefTJoin('patient_ab_post_exposures', 'patient_abs.id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->leftJoin('patient_ab_exposures', 'patient_abs.id', '=', 'patient_ab_exposures.patient_ab_id')
            ->join('patients', 'patient_abs.patient_id', '=', 'patients.id')
/*            ->join('household_members', 'patient_abs.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')*/
            ->join('users', 'patient_ab_pre_exposures.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_abs.facility_code', 'patient_abs.patient_id');
            })
            ->whereNull('patient_ab_pre_exposures.deleted_at')
            ->when($request->params == 'male', function ($query) use ($request) {
                $query->where('patients.gender', 'M');
            })
            ->when($request->params == 'female', function ($query) use ($request) {
                $query->where('patients.gender', 'F');
            })
            ->when($request->params == 'male_female_total', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F']);
            })
            ->when($request->params == 'less_than_15', function ($query) use ($request) {
                $query->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.birthdate, day0_date) < 15"));
            })
            ->when($request->params == 'greater_than_15', function ($query) use ($request) {
                $query->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.birthdate, day0_date) >= 15"));
            })
            ->when($request->params == 'less_than_and_greater_than_15', function ($query) use ($request) {
                $query->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.birthdate, day0_date) >= 15"))
                    ->orWhere(DB::raw("TIMESTAMPDIFF(YEAR, patients.birthdate, day0_date) < 15"));
            })
            ->when($request->params == 'category1', function ($query) use ($request) {
                $query->where('category_id', 1);
            })
            ->when($request->params == 'category2', function ($query) use ($request) {
                $query->where('category_id', 2);
            })
            ->when($request->params == 'category3', function ($query) use ($request) {
                $query->where('category_id', 3);
            })
            ->when($request->params == 'category3', function ($query) use ($request) {
                $query->whereIn('category_id', [2, 3]);
            })
            ->when($request->params == 'prep_total', function ($query) use ($request) {
                $query->whereRaw("COUNT(patient_ab_pre_exposures.patient_id)");
            })
            ->when($request->params == 'prep_completed', function ($query) use ($request) {
                $query->whereNotNull('patient_ab_pre_exposures.day0_date')
                    ->whereNotNull('patient_ab_pre_exposures.day7_date')
                    ->whereNotNull('patient_ab_pre_exposures.day21_date');
            })
            ->when($request->params == 'tandok', function ($query) use ($request) {
                $query->whereNotNull('patient_ab_exposures.tandok_name');
            })
            ->when($request->params == 'prep_completed', function ($query) use ($request) {
                $query->whereNotNull('patient_ab_pre_exposures.day0_date')
                    ->whereNotNull('patient_ab_pre_exposures.day7_date')
                    ->whereNotNull('patient_ab_pre_exposures.day21_date');
            })
            ->when($request->params == 'tcv', function ($query) use ($request) {
                $query->whereNotNull('patient_ab_post_exposures.day0_date');
            })
            ->when($request->params == 'hrig', function ($query) use ($request) {
                $query->where('rig_type_code', 'HRIG');
            })
            ->when($request->params == 'erig', function ($query) use ($request) {
                $query->where('rig_type_code', 'ERIG');
            })
            ->when($request->params == 'dog', function ($query) use ($request) {
                $query->where('animal_type_code', 1);
            })
            ->when($request->params == 'cat', function ($query) use ($request) {
                $query->where('animal_type_code', 2);
            })
            ->when($request->params == 'others', function ($query) use ($request) {
                $query->whereIn('animal_type_code', [3, 4, 5]);
            })
            ->when($request->params == 'total_biting_animal', function ($query) use ($request) {
                $query->whereIn('animal_type_code', [1, 2, 3, 4, 5]);
            })
            ->where('barangays.code', $request->barangay_code)
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
            ->whereBetween(DB::raw('DATE(day0_date)'), [$request->start_date, $request->end_date])
            ->groupBy('municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code')
            ->orderBy('name');
    }
}
