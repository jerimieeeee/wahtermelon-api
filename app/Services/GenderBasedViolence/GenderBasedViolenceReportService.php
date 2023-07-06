<?php

namespace App\Services\GenderBasedViolence;

use Illuminate\Support\Facades\DB;

class GenderBasedViolenceReportService
{
        public function get_all_barangay_municipality($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('municipalities')
            ->selectRaw("
                        age,
                        municipalities.name AS municipality_name,
                        barangays.name AS barangay_name,
                        IF(sexual_abuse_count IS NULL, '0', sexual_abuse_count) AS sexual_abuse_count
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->leftJoinSub($this->get_gbv_report_sexual_abuse($request, $patient_gender, $age_year_bracket1, $age_year_bracket2), 'sexual_abuse', function ($join) {
                $join->on('sexual_abuse.barangay_code', '=', 'barangays.code');
            })
            ->when($request->category == 'municipality',  function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            });
    }


    public function get_gbv_report_sexual_abuse($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
//        return DB::table('patient_gbv_intakes')
//            ->selectRaw("
//                        gender,
//                        case_date,
//                        geographic_id,
//                        TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
//                        CASE WHEN same_address_flag = 1 THEN
//                            household_folders.barangay_code
//                        WHEN same_address_flag = 0 THEN
//                            patient_gbv_intakes.barangay_code
//                        END AS barangay_code,
//                        SUM(sexual_abuse_flag) AS sexual_abuse_count
//                    ")
//            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
//            ->leftJoin('barangays', 'patient_gbv_intakes.barangay_code', '=', 'barangays.code')
//            ->leftJoin('household_members', 'patient_gbv_intakes.patient_id', '=', 'household_members.patient_id')
//            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
//            ->groupBy('birthdate', 'case_date', 'barangay_code');

        return DB::table(function ($query) use ($request, $patient_gender, $age_year_bracket1, $age_year_bracket2) {
            $query->selectRaw("
                        gender,
                        case_date,
                        geographic_id,
                        TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
                        CASE WHEN same_address_flag = 1 THEN
                            household_folders.barangay_code
                        WHEN same_address_flag = 0 THEN
                            patient_gbv_intakes.barangay_code
                        END AS barangay_code,
                        SUM(sexual_abuse_flag) AS sexual_abuse_count
                    ")
            ->from('patient_gbv_intakes')
            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'patient_gbv_intakes.barangay_code', '=', 'barangays.code')
            ->leftJoin('household_members', 'patient_gbv_intakes.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->groupBy('birthdate', 'case_date', 'barangay_code', 'gender', 'geographic_id');
        })
            ->selectRaw('
                        gender,
                        case_date,
                        geographic_id,
                        age,
                        barangay_code,
                        sexual_abuse_count
            ')
            ->whereGender($patient_gender)
            ->whereBetween('case_date', [$request->start_date, $request->end_date])
            ->havingRaw('age BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2]);
    }

    public function get_gbv_report_physical_abuse($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
//        return DB::table('patient_gbv_intakes')
//            ->selectRaw("
//                            gender,
//                            TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
//                            case_date,
//                            municipalities_brgy.barangay_name AS barangay_name,
//                            municipalities_brgy.municipality_name AS municipality_name,
//                            barangays.name AS intake_barangay_name,
//                            SUM(physical_abuse_flag) AS physical_abuse_count
//		            ")
//            ->from('patient_gbv_intakes')
//            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
//            ->join('barangays', 'patient_gbv_intakes.barangay_code', 'barangays.code')
//            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
//                $join->on('municipalities_brgy.patient_id', '=', 'patient_gbv_intakes.patient_id');
//            })
//            ->when($request->category == 'municipality', function ($q) use ($request) {
//                $q->whereIn('municipality_code', explode(',', $request->code));
//            })
//            ->when($request->category == 'barangay', function ($q) use ($request) {
//                $q->whereRaw('
//                            CASE WHEN same_address_flag = 1 THEN
//                                municipalities_brgy.barangay_code IN(?)
//                            WHEN same_address_flag = 0 THEN
//                                patient_gbv_intakes.barangay_code IN(?)
//                            END', [$request->code, $request->code]
//                );
//            })
//            ->whereGender($patient_gender)
//            ->whereBetween('case_date', [$request->start_date, $request->end_date])
//            ->havingRaw('age BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2])
//            ->groupBy('municipalities_brgy.barangay_code', 'patient_gbv_intakes.barangay_code')
//            ->orderBy('age', 'ASC');
    }
}
