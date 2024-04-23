<?php

namespace App\Services\TBDots;

use Illuminate\Support\Facades\DB;

class TBDotsReportService
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
            ->leftJoin('barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
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
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id');
//            ->groupBy('patient_id', 'municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_notified_tb_cases_all_forms($request, $gender)
    {
        return DB::table('patient_tb_case_findings')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        consult_date AS date_of_service
                    ")
            ->join('patient_tbs', 'patient_tb_case_findings.patient_tb_id', '=', 'patient_tbs.id')
            ->join('patients', 'patient_tb_case_findings.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tb_case_findings.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_tb_case_findings.facility_code', auth()->user()->facility_code);
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
            ->where('reg_group_code', ['N', 'O', 'PTLOU', 'R', 'TAF', 'TALF'])
            ->whereGender($gender)
            ->whereYear('consult_date', $request->year)
            ->whereMonth('consult_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_drtb_drug_resistant_confirmed($request, $gender)
    {
        return DB::table('patient_tb_case_holdings')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        treatment_end AS date_of_service
                    ")
            ->join('patient_tbs', 'patient_tb_case_holdings.patient_tb_id', '=', 'patient_tbs.id')
            ->join('patients', 'patient_tb_case_holdings.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tb_case_holdings.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_tb_case_holdings.facility_code', auth()->user()->facility_code);
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
            ->whereBacteriologicalStatusCode('BC')
            ->whereDrugResistantFlag(1)
            ->whereGender($gender)
            ->whereYear('registration_date', $request->year)
            ->whereMonth('registration_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_tb_outcome_cured_and_complete($request, $gender)
    {
        return DB::table('patient_tbs')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        outcome_date AS date_of_service
                    ")
            ->join('patient_tb_case_holdings', 'patient_tbs.id', '=', 'patient_tb_case_holdings.patient_tb_id')
            ->join('patients', 'patient_tbs.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tbs.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_tbs.facility_code', auth()->user()->facility_code);
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
            ->whereIn('tb_treatment_outcome_code', ['C', 'TR'])
            ->whereTreatmentDone(1)
            ->whereGender($gender)
            ->whereYear('outcome_date', $request->year)
            ->whereMonth('outcome_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_tb_drtb_outcome_cured_and_complete($request, $gender)
    {
        return DB::table('patient_tbs')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        outcome_date AS date_of_service
                    ")
            ->join('patient_tb_case_holdings', 'patient_tbs.id', '=', 'patient_tb_case_holdings.patient_tb_id')
            ->join('patients', 'patient_tbs.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_tbs.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_tbs.facility_code', auth()->user()->facility_code);
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
            ->whereBacteriologicalStatusCode('BC')
            ->whereDrugResistantFlag(1)
            ->whereIn('tb_treatment_outcome_code', ['C', 'TR'])
            ->whereTreatmentDone(1)
            ->whereGender($gender)
            ->whereYear('outcome_date', $request->year)
            ->whereMonth('outcome_date', $request->month)
            ->orderBy('name', 'ASC');
    }
}
