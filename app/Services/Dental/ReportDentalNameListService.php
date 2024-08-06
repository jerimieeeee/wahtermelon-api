<?php

namespace App\Services\Dental;

use Illuminate\Support\Facades\DB;

class ReportDentalNameListService
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
        return DB::table('consults')
            ->selectRaw("
                        patient_ab_exposures.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        exposure_date AS date_of_service
                        ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_tooth_services', 'consults.id', '=', 'dental_tooth_services.consult_id')
            ->leftJoin('dental_services', 'consults.id', '=', 'dental_services.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consults.facility_code', auth()->user()->facility_code);
            })
            // orally fit 12-59 months male
            ->when($request->params == 'male_12_59_months_orally_fit', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->where('orally_fit_flag', 1)
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59)");
            })
            // orally fit 12-59 months female
            ->when($request->params == 'female_12_59_months_orally_fit', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->where('orally_fit_flag', 1)
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59)");
            })
            // orally fit 12-59 months total male and female
            ->when($request->params == 'male_female_12_59_months_orally_fit', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->where('orally_fit_flag', 1)
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59)");
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consults.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->groupBy('patient_ab_exposures.patient_id')
            ->orderBy('name');
    }
}
