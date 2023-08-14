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

    public function get_household_profiling_philhealth_category($request, $patient_gender)
    {
        return DB::table('patients')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->when($request->category == 'facility', function ($q) {
                $q->where('patient_ccdevs.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->whereYear('birthdate', $request->year)
            ->whereMonth('birthdate', $request->month)
            ->orderBy('name', 'ASC');
    }
}
