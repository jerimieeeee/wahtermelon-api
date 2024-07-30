<?php

namespace App\Services\AnimalBite;

use Illuminate\Support\Facades\DB;

class ReportAnimalBitePreExposureNameListService
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
        return DB::table('patient_ab_pre_exposures')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        birthdate,
                        day0_date AS date_of_service,
                        ")
            ->join('patients', 'patient_ab_pre_exposures.patient_id', '=', 'patients.id')
            ->join('household_members', 'patient_ab_pre_exposures.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->whereNull('patient_ab_pre_exposures.deleted_at')
            // total for cat2, cat3, and both
            ->when($request->params == 'male', function ($query) use ($request) {
                $query->whereGender('M');
            })
            ->when($request->params == 'female', function ($query) use ($request) {
                $query->whereGender('F');
            })
            ->when($request->params == 'male_female_total', function ($query) use ($request) {
                $query->whereIn('gender', ['M', 'F']);
            })
            ->when($request->params == 'less_than_15', function ($query) use ($request) {
                $query->where(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, day0_date) < 15"));
            })
            ->when($request->params == 'greater_than_15', function ($query) use ($request) {
                $query->where(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, day0_date) >= 15"));
            })
            ->when($request->params == 'less_than_and_greater_than_15', function ($query) use ($request) {
                $query->where(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, day0_date) >= 15"))
                    ->orWhere(DB::raw("TIMESTAMPDIFF(YEAR, birthdate, day0_date) < 15"));
            })
            ->when($request->params == 'day0', function ($query) use ($request) {
                $query->whereNotNull('day0_date');
            })
            ->when($request->params == 'day0_day7', function ($query) use ($request) {
                $query->whereNotNull('day0_date')
                    ->whereNotNull('day7_date');
            })
            ->when($request->params == 'day0_day7_day21', function ($query) use ($request) {
                $query->orWhereNotNull('day0_date')
                    ->orWhereNotNull('day3_date')
                    ->orWhereNotNull('day7_date');
            })
            ->where('barangays.code', $request->barangay_code)
            ->where('patient_ab_pre_exposures.facility_code', auth()->user()->facility_code)
            ->whereBetween(DB::raw('DATE(day0_date)'), [$request->start_date, $request->end_date])
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('household_folders.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('household_folders.barangay_code', explode(',', $request->code));
            })
            ->groupBy('barangays.name')
            ->orderBy('name');
    }
}
