<?php

namespace App\Services\TBDots;

use Illuminate\Support\Facades\DB;

class TBDotsReportService
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

    public function get_all_brgy_municipalities_patient()
    {
        return DB::table('municipalities')
            ->selectRaw('
                        patient_id,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
//            ->join('patients', 'household_members.patient_id', '=', 'patients.id');
//            ->groupBy('patient_id', 'municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_notified_tb_cases_all_forms($request, $gender)
    {
        return DB::table('patient_tb_case_findings')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        consult_date AS date_of_service
                    ")
            ->join('patient_tbs', 'patient_tb_case_findings.patient_tb_id', '=', 'patient_tbs.id')
            ->join('patients', 'patient_tb_case_findings.patient_id', '=', 'patients.id')
            ->join('users', 'patient_tb_case_findings.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tb_case_findings.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_tb_case_findings.facility_code', auth()->user()->facility_code);
            })
            ->whereNull('patient_tb_case_findings.deleted_at')
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('reg_group_code', ['N', 'O', 'PTLOU', 'R', 'TAF', 'TALF'])
            ->where('patients.gender', $gender)
            ->whereYear('consult_date', $request->year)
            ->whereMonth('consult_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_drtb_drug_resistant_confirmed($request, $gender)
    {
        return DB::table('patient_tb_case_holdings')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        treatment_end AS date_of_service
                    ")
            ->join('patient_tbs', 'patient_tb_case_holdings.patient_tb_id', '=', 'patient_tbs.id')
            ->join('patients', 'patient_tb_case_holdings.patient_id', '=', 'patients.id')
            ->join('users', 'patient_tb_case_holdings.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tb_case_holdings.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_tb_case_holdings.facility_code', auth()->user()->facility_code);
            })
            ->whereNull('patient_tb_case_holdings.deleted_at')
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereBacteriologicalStatusCode('BC')
            ->whereDrugResistantFlag(1)
            ->where('patients.gender', $gender)
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_tb_outcome_cured_and_complete($request, $gender)
    {
        return DB::table('patient_tbs')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        outcome_date AS date_of_service
                    ")
            ->join('patient_tb_case_holdings', 'patient_tbs.id', '=', 'patient_tb_case_holdings.patient_tb_id')
            ->join('patients', 'patient_tbs.patient_id', '=', 'patients.id')
            ->join('users', 'patient_tbs.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tbs.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_tbs.facility_code', auth()->user()->facility_code);
            })
            ->whereNull('patient_tbs.deleted_at')
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereIn('tb_treatment_outcome_code', ['C', 'TR'])
            ->whereTreatmentDone(1)
            ->where('patients.gender', $gender)
            ->whereYear('outcome_date', $request->year)
            ->whereMonth('outcome_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_tb_drtb_outcome_cured_and_complete($request, $gender)
    {
        return DB::table('patient_tbs')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        outcome_date AS date_of_service
                    ")
            ->join('patient_tb_case_holdings', 'patient_tbs.id', '=', 'patient_tb_case_holdings.patient_tb_id')
            ->join('patients', 'patient_tbs.patient_id', '=', 'patients.id')
            ->join('users', 'patient_tbs.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tbs.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_tbs.facility_code', auth()->user()->facility_code);
            })
            ->whereNull('patient_tbs.deleted_at')
            ->where('patient_tbs.facility_code', auth()->user()->facility_code)
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereBacteriologicalStatusCode('BC')
            ->whereDrugResistantFlag(1)
            ->whereIn('tb_treatment_outcome_code', ['C', 'TR'])
            ->whereTreatmentDone(1)
            ->where('patients.gender', $gender)
            ->whereYear('outcome_date', $request->year)
            ->whereMonth('outcome_date', $request->month)
            ->orderBy('name', 'ASC');
    }
}
