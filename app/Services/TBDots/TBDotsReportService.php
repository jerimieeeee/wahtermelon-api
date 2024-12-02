<?php

namespace App\Services\TBDots;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class TBDotsReportService
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
            ->whereNull('patient_tb_case_findings.deleted_at')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_tb_case_findings.facility_code', 'patient_tb_case_findings.patient_id');
            })
            ->where('reg_group_code', ['N', 'O', 'PTLOU', 'R', 'TAF', 'TALF'])
            ->where('patients.gender', $gender)
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('consult_date', $request->year)
//            ->whereMonth('consult_date', $request->month)
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
            ->whereNull('patient_tb_case_holdings.deleted_at')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_tb_case_holdings.facility_code', 'patient_tb_case_holdings.patient_id');
            })
            ->whereBacteriologicalStatusCode('BC')
            ->whereDrugResistantFlag(1)
            ->where('patients.gender', $gender)
            ->whereBetween(DB::raw('DATE(treatment_end)'), [$request->start_date, $request->end_date])
//            ->whereYear('registration_date', $request->year)
//            ->whereMonth('registration_date', $request->month)
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
            ->whereNull('patient_tbs.deleted_at')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_tbs.facility_code', 'patient_tbs.patient_id');
            })
            ->whereIn('tb_treatment_outcome_code', ['C', 'TR'])
            ->whereTreatmentDone(1)
            ->where('patients.gender', $gender)
            ->whereBetween(DB::raw('DATE(outcome_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('outcome_date', $request->year)
//            ->whereMonth('outcome_date', $request->month)
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
            ->whereNull('patient_tbs.deleted_at')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_tbs.facility_code', 'patient_tbs.patient_id');
            })
            ->whereBacteriologicalStatusCode('BC')
            ->whereDrugResistantFlag(1)
            ->whereIn('tb_treatment_outcome_code', ['C', 'TR'])
            ->whereTreatmentDone(1)
            ->where('patients.gender', $gender)
            ->whereBetween(DB::raw('DATE(outcome_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('outcome_date', $request->year)
//            ->whereMonth('outcome_date', $request->month)
            ->orderBy('name', 'ASC');
    }
}
