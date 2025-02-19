<?php

namespace App\Services\NCD;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class NcdReportService
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
    }

    public function get_risk_assessed($request, $patient_gender, $age)
    {
        return DB::table('consult_ncd_risk_assessment')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('patients', 'consult_ncd_risk_assessment.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ncd_risk_assessment.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_assessment.facility_code', 'consult_ncd_risk_assessment.patient_id');
            })
            ->when($age == 'normal', function ($q) use ($request) {
                $q->whereBetween('age', [20, 59]);
            })
            ->when($age == 'senior', function ($q) use ($request) {
                $q->where('age', '>=', '60');
            })
            ->where('consult_ncd_risk_assessment.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('assessment_date', $request->year)
//            ->whereMonth('assessment_date', $request->month)
            ->groupBy('consult_ncd_risk_assessment.patient_id')
            ->orderBy('name', 'ASC');
    }

    public function get_risk_assessed_smoker($request, $patient_gender, $age)
    {
        return DB::table('consult_ncd_risk_assessment')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('patients', 'consult_ncd_risk_assessment.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ncd_risk_assessment.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_assessment.facility_code', 'consult_ncd_risk_assessment.patient_id');
            })
            ->when($age == 'normal', function ($q) use ($request) {
                $q->whereBetween('age', [20, 59]);
            })
            ->when($age == 'senior', function ($q) use ($request) {
                $q->where('age', '>=', '60');
            })
            ->where('consult_ncd_risk_assessment.gender', $patient_gender)
            ->whereSmoking(3)
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('assessment_date', $request->year)
//            ->whereMonth('assessment_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_risk_assessed_alcohol($request, $patient_gender, $age)
    {
        return DB::table('consult_ncd_risk_assessment')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('patients', 'consult_ncd_risk_assessment.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ncd_risk_assessment.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_assessment.facility_code', 'consult_ncd_risk_assessment.patient_id');
            })
            ->when($age == 'normal', function ($q) use ($request) {
                $q->whereBetween('age', [20, 59]);
            })
            ->when($age == 'senior', function ($q) use ($request) {
                $q->where('age', '>=', '60');
            })
            ->where('consult_ncd_risk_assessment.gender', $patient_gender)
            ->whereAlcoholIntake(1)
            ->whereExcessiveAlcoholIntake('Y')
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('assessment_date', $request->year)
//            ->whereMonth('assessment_date', $request->month)
            ->groupBy('consult_ncd_risk_assessment.patient_id', 'assessment_date')
            ->orderBy('name', 'ASC');
    }

    public function get_risk_assessed_obese($request, $patient_gender, $age)
    {
        return DB::table('consult_ncd_risk_assessment')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('patients', 'consult_ncd_risk_assessment.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ncd_risk_assessment.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_assessment.facility_code', 'consult_ncd_risk_assessment.patient_id');
            })
            ->when($age == 'normal', function ($q) use ($request) {
                $q->whereBetween('age', [20, 59]);
            })
            ->when($age == 'senior', function ($q) use ($request) {
                $q->where('age', '>=', '60');
            })
            ->where('consult_ncd_risk_assessment.gender', $patient_gender)
            ->whereObesity(1)
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('assessment_date', $request->year)
//            ->whereMonth('assessment_date', $request->month)
            ->groupBy('consult_ncd_risk_assessment.patient_id', 'assessment_date')
            ->orderBy('name', 'ASC');
    }

    public function hypertensive_adult($request, $patient_gender, $age)
    {
        return DB::table('consult_ncd_risk_assessment')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('patients', 'consult_ncd_risk_assessment.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ncd_risk_assessment.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_assessment.facility_code', 'consult_ncd_risk_assessment.patient_id');
            })
            ->when($age == 'normal', function ($q) use ($request) {
                $q->whereBetween('age', [20, 59]);
            })
            ->when($age == 'senior', function ($q) use ($request) {
                $q->where('age', '>=', '60');
            })
            ->where('consult_ncd_risk_assessment.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('assessment_date', $request->year)
//            ->whereMonth('assessment_date', $request->month)
            ->whereRaisedBp(1)
            ->groupBy('consult_ncd_risk_assessment.patient_id', 'assessment_date')
            ->orderBy('name', 'ASC');
    }

    public function hypertensive_adult_old_new_case($request, $patient_gender, $age)
    {
        return DB::table('consult_ncd_risk_assessment')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('patients', 'consult_ncd_risk_assessment.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ncd_risk_assessment.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_assessment.facility_code', 'consult_ncd_risk_assessment.patient_id');
            })
            ->when($age == 'normal', function ($q) use ($request) {
                $q->whereBetween('age', [20, 59]);
            })
            ->when($age == 'senior', function ($q) use ($request) {
                $q->where('age', '>=', '60');
            })
            ->where('consult_ncd_risk_assessment.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
            ->whereRaisedBp(1)
            ->whereHypertensiveOldCase(0)
            ->groupBy('consult_ncd_risk_assessment.patient_id', 'assessment_date')
            ->orderBy('name', 'ASC');
    }

    public function diabetes_adult($request, $patient_gender, $age)
    {
        return DB::table('consult_ncd_risk_assessment')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('patients', 'consult_ncd_risk_assessment.patient_id', '=', 'patients.id')
            ->join('consult_ncd_risk_screening_glucose', 'consult_ncd_risk_assessment.patient_id', '=', 'consult_ncd_risk_screening_glucose.patient_id')
            ->join('users', 'consult_ncd_risk_assessment.user_id', '=', 'users.id')
            ->where('consult_ncd_risk_assessment.facility_code', auth()->user()->facility_code)
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_assessment.facility_code', 'consult_ncd_risk_assessment.patient_id');
            })
            ->when($age == 'normal', function ($q) use ($request) {
                $q->whereBetween('age', [20, 59]);
            })
            ->when($age == 'senior', function ($q) use ($request) {
                $q->where('age', '>=', '60');
            })
            ->where('patients.gender', $patient_gender)
            ->whereRaisedBloodGlucose(1)
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('assessment_date', $request->year)
//            ->whereMonth('assessment_date', $request->month)
            ->groupBy('consult_ncd_risk_assessment.patient_id', 'assessment_date')
            ->orderBy('name', 'ASC');
    }

    public function senior_ppv($request, $patient_gender)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        vaccine_date AS date_of_service
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vaccines.facility_code', 'patient_vaccines.patient_id');
            })
            ->where('patients.gender',$patient_gender)
            ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) >= 60',)
            ->whereVaccineId('PPV')
            ->whereStatusId(1)
            ->whereBetween(DB::raw('DATE(vaccine_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('vaccine_date', $request->year)
//            ->whereMonth('vaccine_date', $request->month)
            ->groupBy('patient_vaccines.patient_id', 'vaccine_date')
            ->orderBy('name', 'ASC');
    }

    public function senior_influenza($request, $patient_gender)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        vaccine_date AS date_of_service
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vaccines.facility_code', 'patient_vaccines.patient_id');
            })
            ->where('patients.gender',$patient_gender)
            ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) >= 60',)
            ->whereVaccineId('IV')
            ->whereStatusId(1)
            ->whereBetween(DB::raw('DATE(vaccine_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('vaccine_date', $request->year)
//            ->whereMonth('vaccine_date', $request->month)
            ->groupBy('patient_vaccines.patient_id', 'vaccine_date')
            ->orderBy('name', 'ASC');
    }

    public function eye_problems_disease($request, $patient_gender, $indicator)
    {
        return DB::table('consult_ncd_risk_casdt2s')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        assessment_date AS date_of_service
                    ")
            ->join('consult_ncd_risk_assessment', 'consult_ncd_risk_casdt2s.consult_ncd_risk_id', '=', 'consult_ncd_risk_assessment.id')
            ->join('patients', 'consult_ncd_risk_casdt2s.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ncd_risk_casdt2s.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ncd_risk_casdt2s.facility_code', 'consult_ncd_risk_casdt2s.patient_id');
            })
            ->where('patients.gender',$patient_gender)
            ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, assessment_date) >= 60')
            ->when($indicator == 'eye_problem', function ($q) {
                $q->whereNotNull('eye_refer');
            })
            ->when($request->indicator == 'eye_refer_prof', function ($q) {
                $q->whereNotNull('eye_refer_prof');
            })
            ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
            ->groupBy('consult_ncd_risk_casdt2s.patient_id', 'assessment_date')
            ->orderBy('name', 'ASC');
    }
}
