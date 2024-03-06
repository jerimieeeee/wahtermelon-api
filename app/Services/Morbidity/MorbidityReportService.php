<?php

namespace App\Services\Morbidity;

use Illuminate\Support\Facades\DB;

class MorbidityReportService
{
//    public function get_morbidity_icd10_desc()
//    {
//        return DB::table('lib_icd10s')
//            ->selectRaw('
//                        icd10_desc
//                    ');
//    }

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

    public function get_morbidity_report_all_gender($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            CONCAT(household_folders.address, ',', ' ', barangays.name) AS address,
                            birthdate,
                            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                            consult_notes_final_dxes.icd10_code AS icd10_code,
                            icd10_desc,
                            gender
                    ")
                ->from('consult_notes_final_dxes')
                ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
                ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
                ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
                ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
                ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
                ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
                ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('barangays.psgc_10_digit_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangays.psgc_10_digit_code', explode(',', $request->code));
                })
                ->whereGender($patient_gender);
        })
            ->selectRaw('
                        name,
                        address,
                        birthdate,
                        date_of_service,
                        CONCAT(icd10_code, ";", " ", icd10_desc) AS icd10_desc
            ')
            ->whereBetween('date_of_service', [$request->start_date, $request->end_date])
            ->orderBy('name', 'ASC');
    }

    public function get_morbidity_report_age_days($request, $patient_gender, $age_bracket1, $age_bracket2)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            CONCAT(household_folders.address, ',', ' ', barangays.name) AS address,
                            birthdate,
                            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                            consult_notes_final_dxes.icd10_code AS icd10_code,
                            icd10_desc,
                            TIMESTAMPDIFF(YEAR, birthdate, consult_date) AS age_year,
                            TIMESTAMPDIFF(MONTH, birthdate, consult_date) % 12 AS age_month,
                            FLOOR(TIMESTAMPDIFF(DAY, birthdate, consult_date) % 29) AS age_day
                    ")
                ->from('consult_notes_final_dxes')
                ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
                ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
                ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
                ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
                ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
                ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
                ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('barangays.psgc_10_digit_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangays.psgc_10_digit_code', explode(',', $request->code));
                })
                ->whereGender($patient_gender);
        })
            ->selectRaw('
                        name,
                        address,
                        birthdate,
                        date_of_service,
                        CONCAT(icd10_code, ";", " ", icd10_desc) AS icd10_desc,
                        age_year,
                        age_month,
                        age_day
            ')
            ->whereBetween('date_of_service', [$request->start_date, $request->end_date])
            ->havingRaw('(age_year = 0) AND (age_month = 0) AND (age_day BETWEEN ? AND ?)', [$age_bracket1, $age_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function get_morbidity_report_age_days_and_month($request, $patient_gender, $age_day, $age_bracket1, $age_bracket2)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            CONCAT(household_folders.address, ',', ' ', barangays.name) AS address,
                            birthdate,
                            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                            consult_notes_final_dxes.icd10_code AS icd10_code,
                            icd10_desc,
                            TIMESTAMPDIFF(YEAR, birthdate, consult_date) AS age_year,
                            TIMESTAMPDIFF(MONTH, birthdate, consult_date) % 12 AS age_month,
                            FLOOR(TIMESTAMPDIFF(DAY, birthdate, consult_date) % 29) AS age_day
                    ")
                ->from('consult_notes_final_dxes')
                ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
                ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
                ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
                ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
                ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
                ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
                ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('barangays.psgc_10_digit_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangays.psgc_10_digit_code', explode(',', $request->code));
                })
                ->whereGender($patient_gender);
        })
            ->selectRaw('
                        name,
                        address,
                        birthdate,
                        date_of_service,
                        CONCAT(icd10_code, ";", " ", icd10_desc) AS icd10_desc,
                        age_year,
                        age_month,
                        age_day
            ')
            ->whereBetween('date_of_service', [$request->start_date, $request->end_date])
            ->havingRaw('(age_year = 0) AND (age_day >= ? OR age_month BETWEEN ? AND ?)', [$age_day, $age_bracket1, $age_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function get_morbidity_report_year($request, $patient_gender, $age_bracket1, $age_bracket2)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            CONCAT(household_folders.address, ',', ' ', barangays.name) AS address,
                            birthdate,
                            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                            consult_notes_final_dxes.icd10_code AS icd10_code,
                            icd10_desc,
                            TIMESTAMPDIFF(YEAR, birthdate, consult_date) AS age_year,
                            TIMESTAMPDIFF(MONTH, birthdate, consult_date) % 12 AS age_month,
                            FLOOR(TIMESTAMPDIFF(DAY, birthdate, consult_date) % 29) AS age_day
                    ")
                ->from('consult_notes_final_dxes')
                ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
                ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
                ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
                ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
                ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
                ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
                ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('barangays.psgc_10_digit_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangays.psgc_10_digit_code', explode(',', $request->code));
                })
                ->whereGender($patient_gender);
        })
            ->selectRaw('
                        name,
                        address,
                        birthdate,
                        date_of_service,
                        CONCAT(icd10_code, ";", " ", icd10_desc) AS icd10_desc,
                        age_year
            ')
            ->whereBetween('date_of_service', [$request->start_date, $request->end_date])
            ->havingRaw('age_year BETWEEN ? AND ?', [$age_bracket1, $age_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function get_morbidity_report_70_years_above($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            CONCAT(household_folders.address, ',', ' ', barangays.name) AS address,
                            birthdate,
                            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                            consult_notes_final_dxes.icd10_code AS icd10_code,
                            icd10_desc,
                            TIMESTAMPDIFF(YEAR, birthdate, consult_date) AS age_year,
                            TIMESTAMPDIFF(MONTH, birthdate, consult_date) % 12 AS age_month,
                            FLOOR(TIMESTAMPDIFF(DAY, birthdate, consult_date) % 29) AS age_day
                    ")
                ->from('consult_notes_final_dxes')
                ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
                ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
                ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
                ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
                ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
                ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
                ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('barangays.psgc_10_digit_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangays.psgc_10_digit_code', explode(',', $request->code));
                })
                ->whereGender($patient_gender);
            })
            ->selectRaw('
                        name,
                        address,
                        birthdate,
                        date_of_service,
                        CONCAT(icd10_code, ";", " ", icd10_desc) AS icd10_desc,
                        age_year,
                        age_month,
                        age_day
            ')
            ->whereBetween('date_of_service', [$request->start_date, $request->end_date])
            ->havingRaw('age_year >= 70')
            ->orderBy('name', 'ASC');
    }
}
