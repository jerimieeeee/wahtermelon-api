<?php

namespace App\Services\Household;

use Illuminate\Support\Facades\DB;

class HouseholdEnvironmentalReportService
{
    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code,
                        name AS barangay_name,
                        year,
                        settings_catchment_barangays.population,
                        (SELECT SUM(population) FROM settings_catchment_barangays) AS total_population
                    ')
            ->leftJoin('barangays', 'barangays.code', '=', 'settings_catchment_barangays.barangay_code')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code', 'barangay_code', 'year', 'population');
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
            ->when($request->category == 'all', function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
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
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month);
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
            ->when($request->category == 'all', function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            })
            ->whereSafetyManagedFlag(1)
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month);
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
            ->when($request->category == 'all', function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
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
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month);
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
            ->when($request->category == 'all', function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            })
            ->whereSanitationManagedFlag(1)
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month);
    }

    public function get_zod_barangays($request)
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw("
                        barangays.name AS barangay_name
                    ")
            ->join('barangays', 'settings_catchment_barangays.barangay_code', '=', 'barangays.code')
            ->when($request->category == 'all', function ($q) {
                $q->where('household_environmentals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            })
            ->whereZod(1)
            ->whereYear('updated_at', $request->year)
            ->whereMonth('updated_at', $request->month);
    }
}
