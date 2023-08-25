<?php

namespace App\Services\GenderBasedViolence;

use Illuminate\Support\Facades\DB;

class GenderBasedViolenceReportService
{
    public function get_gbv_catalyst_report_abuses($request, $patient_gender, $age_year_bracket1, $age_year_bracket2, $type1, $type2)
    {
        return DB::table('barangays')
            ->selectRaw("
                        gender,
                        age,
                        municipalities.name AS municipality_name,
                        barangays.name AS barangay_name,
                        CASE WHEN {$type2} IS NULL OR {$type2} = 0 THEN '-' ELSE {$type2} END AS {$type2}
                    ")
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoinSub($this->get_gbv_report_abuses($request, $patient_gender, $age_year_bracket1, $age_year_bracket2, $type1), 'abuse', function ($join) {
                $join->on('barangays.code', '=', 'abuse.barangay_code');
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->where('municipalities.code', $request->code);
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            });
    }

    public function get_gbv_report_abuses($request, $patient_gender, $age_year_bracket1, $age_year_bracket2, $type1)
    {
        return DB::table('patient_gbv_intakes')
            ->selectRaw("
                        gender,
                        case_date,
                        TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
                        CASE WHEN same_address_flag = 1 THEN
                            household_folders.barangay_code
                        WHEN same_address_flag = 0 THEN
                            patient_gbv_intakes.barangay_code
                        END AS barangay_code,
                        sexual_abuse_flag,
                        physical_abuse_flag,
                        neglect_abuse_flag,
                        emotional_abuse_flag,
                        economic_abuse_flag,
                        utv_abuse_flag,
                        others_abuse_flag,
                        {$type1}
                    ")
            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'patient_gbv_intakes.barangay_code', '=', 'barangays.code')
            ->leftJoin('household_members', 'patient_gbv_intakes.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->whereGender($patient_gender)
            ->whereBetween('case_date', [$request->start_date, $request->end_date])
            ->groupBy('gender', 'case_date', 'birthdate', 'same_address_flag', 'barangay_code', 'sexual_abuse_flag', 'physical_abuse_flag', 'neglect_abuse_flag', 'emotional_abuse_flag', 'economic_abuse_flag', 'utv_abuse_flag', 'others_abuse_flag')
            ->havingRaw('(age BETWEEN ? AND ?) AND ( SUM(sexual_abuse_flag + physical_abuse_flag + neglect_abuse_flag + emotional_abuse_flag + economic_abuse_flag + utv_abuse_flag) <= 1)', [$age_year_bracket1, $age_year_bracket2]);
    }

    public function get_gbv_catalyst_report_abuses2($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('barangays')
            ->selectRaw("
                        gender,
                        age,
                        municipalities.name AS municipality_name,
                        barangays.name AS barangay_name,
                        CASE WHEN COUNT(gender) IS NULL OR COUNT(gender) = 0 THEN '-' ELSE COUNT(gender) END AS count
                    ")
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->leftJoinSub($this->get_gbv_report_abuses2($request, $patient_gender, $age_year_bracket1, $age_year_bracket2), 'abuse', function ($join) {
                $join->on('abuse.barangay_code', '=', 'barangays.code');
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->where('municipalities.code', $request->code);
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            })
            ->groupBy('gender', 'age', 'municipalities.name', 'barangays.name');
    }

    public function get_gbv_report_abuses2($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_gbv_intakes')
            ->selectRaw('
                        gender,
                        case_date,
                        TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
                        CASE WHEN same_address_flag = 1 THEN
                            household_folders.barangay_code
                        WHEN same_address_flag = 0 THEN
                            patient_gbv_intakes.barangay_code
                        END AS barangay_code,
                        sexual_abuse_flag,
                        physical_abuse_flag,
                        neglect_abuse_flag,
                        emotional_abuse_flag,
                        economic_abuse_flag,
                        utv_abuse_flag,
                        others_abuse_flag
                    ')
            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'patient_gbv_intakes.barangay_code', '=', 'barangays.code')
            ->leftJoin('household_members', 'patient_gbv_intakes.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->whereGender($patient_gender)
            ->whereBetween('case_date', [$request->start_date, $request->end_date])
            ->groupBy('gender', 'case_date', 'birthdate', 'same_address_flag', 'barangay_code', 'sexual_abuse_flag', 'physical_abuse_flag', 'neglect_abuse_flag', 'emotional_abuse_flag', 'economic_abuse_flag', 'utv_abuse_flag', 'others_abuse_flag')
            ->havingRaw('(age BETWEEN ? AND ?) AND ( SUM(sexual_abuse_flag + physical_abuse_flag + neglect_abuse_flag + emotional_abuse_flag + economic_abuse_flag + utv_abuse_flag) >= 2)', [$age_year_bracket1, $age_year_bracket2]);
    }
}
