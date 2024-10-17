<?php

namespace App\Services\Household;

use Illuminate\Support\Facades\DB;

class HouseholdEnvironmentalReportService
{
    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                    year,
                    SUM(settings_catchment_barangays.population) AS total_population
                    ')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code');
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
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
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
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'munctiy', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
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
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
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
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
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
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
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
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            })
            ->whereCompleteSanitationFlag(1)
            ->whereBetween(DB::raw('DATE(registration_date)'), [$request->start_date, $request->end_date]);
//            ->whereYear('registration_date', $request->year)
//            ->whereMonth('registration_date', $request->month);
    }

    public function get_zod_barangays($request)
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw("
                        barangays.name AS barangay_name
                    ")
            ->join('barangays', 'settings_catchment_barangays.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->where('settings_catchment_barangays.facility_code', auth()->user()->facility_code)
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('settings_catchment_barangays.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            })
            ->whereZod(1)
            ->whereBetween(DB::raw('DATE(settings_catchment_barangays.updated_at)'), [$request->start_date, $request->end_date]);
//            ->whereYear('settings_catchment_barangays.updated_at', $request->year)
//            ->whereMonth('settings_catchment_barangays.updated_at', $request->month);
    }
}
