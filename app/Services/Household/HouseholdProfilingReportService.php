<?php

namespace App\Services\Household;

use Illuminate\Support\Facades\DB;

class HouseholdProfilingReportService
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

    public function get_household_profiling_summary($request, $type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id,
                        number_of_families,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
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
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month)
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_water_source($request, $type, $water_type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id,
                        number_of_families,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
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
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->when($water_type == 1, function ($q) use ($request, $water_type) {
                $q->where('water_type_code', $water_type);
            })
            ->when($water_type == 2, function ($q) use ($request, $water_type) {
                $q->where('water_type_code', $water_type);
            })
            ->when($water_type == 3, function ($q) use ($request, $water_type) {
                $q->where('water_type_code', $water_type);
            })
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month)
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_toilet_facilities($request, $type, $toilet_code)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id,
                        number_of_families,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
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
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->when($toilet_code == 1, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 2, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 3, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 5, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 6, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 7, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 8, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month)
            ->orderBy('registration_date', 'ASC');
    }
}
