<?php

namespace App\Services\Household;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class HouseholdEnvironmentalReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

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

    public function get_household_environmental_water_source($request, $water_type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id AS family_id,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        family_role_code AS family_role,
                        mobile_number
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->leftJoin('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoin('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('users', 'household_environmentals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request);
            })
            ->when($water_type == 'all', function ($q) use ($request, $water_type) {
                $q->whereIn('water_type_code', [1,2,3]);
            })
            ->when($water_type == 1, function ($q) use ($request) {
                $q->where('water_type_code', 1);
            })
            ->when($water_type == 2, function ($q) use ($request) {
                $q->where('water_type_code', 2);
            })
            ->when($water_type == 3, function ($q) use ($request) {
                $q->where('water_type_code', 3);
            })
            ->whereBetween(DB::raw('DATE(registration_date)'), [$request->start_date, $request->end_date]);
//            ->whereYear('registration_date', $request->year)
//            ->whereMonth('registration_date', $request->month);
    }

    public function get_household_environmental_safety_managed_water($request)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id AS family_id,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        family_role_code AS family_role,
                        mobile_number
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->leftJoin('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoin('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('users', 'household_environmentals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->whereSafetyManagedFlag(1)
            ->whereBetween(DB::raw('DATE(registration_date)'), [$request->start_date, $request->end_date]);
//            ->whereYear('registration_date', $request->year)
//            ->whereMonth('registration_date', $request->month);
    }

    public function get_household_environmental_toilet_type($request, $toilet_type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id AS family_id,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        family_role_code AS family_role,
                        mobile_number
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->leftJoin('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoin('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('users', 'household_environmentals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request);
            })
            ->when($toilet_type == 'all', function ($q) use ($request) {
                $q->where('toilet_facility_code', 1);
            })
            ->when($toilet_type == 1, function ($q) use ($request) {
                $q->where('toilet_facility_code', 1);
            })
            ->when($toilet_type == 2, function ($q) use ($request) {
                $q->where('toilet_facility_code', 2);
            })
            ->when($toilet_type == 3, function ($q) use ($request) {
                $q->where('toilet_facility_code', 3);
            })
            ->whereBetween(DB::raw('DATE(registration_date)'), [$request->start_date, $request->end_date]);
//            ->whereYear('registration_date', $request->year)
//            ->whereMonth('registration_date', $request->month);
    }

    public function get_household_environmental_safety_managed_sanitation($request)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id AS family_id,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        family_role_code AS family_role,
                        mobile_number
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->leftJoin('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoin('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('users', 'household_environmentals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->whereSanitationManagedFlag(1)
            ->whereBetween(DB::raw('DATE(registration_date)'), [$request->start_date, $request->end_date]);
//            ->whereYear('registration_date', $request->year)
//            ->whereMonth('registration_date', $request->month);
    }

    public function get_household_environmental_satisfaction_solid_waste($request)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id AS family_id,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        family_role_code AS family_role,
                        mobile_number
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->leftJoin('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoin('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('users', 'household_environmentals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->whereSatisfactionManagementFlag(1)
            ->whereBetween(DB::raw('DATE(registration_date)'), [$request->start_date, $request->end_date]);
//            ->whereYear('registration_date', $request->year)
//            ->whereMonth('registration_date', $request->month);
    }

    public function get_household_environmental_complete_sanitation($request)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id AS family_id,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        family_role_code AS family_role,
                        mobile_number
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->leftJoin('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoin('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('users', 'household_environmentals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->whereCompleteSanitationFlag(1)
            ->whereBetween(DB::raw('DATE(registration_date)'), [$request->start_date, $request->end_date]);
    }

    public function get_zod_barangays($request)
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw("
                        barangays.name AS barangay_name
                    ")
            ->join('barangays', 'settings_catchment_barangays.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->where('settings_catchment_barangays.facility_code', auth()->user()->facility_code)
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'settings_catchment_barangays.facility_code');
            })
            ->whereZod(1)
            ->whereBetween(DB::raw('DATE(settings_catchment_barangays.updated_at)'), [$request->start_date, $request->end_date]);
    }
}
