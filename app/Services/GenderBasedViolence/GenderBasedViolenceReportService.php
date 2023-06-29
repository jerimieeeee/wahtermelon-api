<?php

namespace App\Services\GenderBasedViolence;

use Illuminate\Support\Facades\DB;

class GenderBasedViolenceReportService
{
    public function get_all_brgy_municipalities_patient()
    {
        return DB::table('municipalities')
            ->selectRaw('
                        patient_id,
                        municipalities.code AS municipality_code,
                        barangays.code AS barangay_code,
                        barangays.name AS barangay_name
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.code', 'barangays.code');
    }

    public function get_gbv_report($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                            gender,
                            case_date,
                            TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
                            sexual_abuse_flag,
                            physical_abuse_flag,
                            emotional_abuse_flag,
                            economic_abuse_flag,
                            others_abuse_flag,
                            same_address_flag,
                            patient_gbv_intakes.barangay_code AS intake_barangay_code,
                            municipalities_brgy.barangay_code,
                            municipalities_brgy.municipality_code,
                            name AS barangay_name
		            ")
                ->from('patient_gbv_intakes')
                ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
                ->join('barangays', 'patient_gbv_intakes.barangay_code', 'barangays.code')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_gbv_intakes.patient_id');
                });
        })
        ->selectRaw("
                    barangay_name,
                    SUM(
                        CASE WHEN sexual_abuse_flag = 1 THEN
                            1
                        ELSE
                            0
                        END) AS sexual_abuse_count,
                    SUM(
                        CASE WHEN physical_abuse_flag = 1 THEN
                            1
                        ELSE
                            0
                        END) AS physical_abuse_count,
                    SUM(
                        CASE WHEN emotional_abuse_flag = 1 THEN
                            1
                        ELSE
                            0
                        END) AS emotional_abuse_count,
                    SUM(
                        CASE WHEN economic_abuse_flag = 1 THEN
                            1
                        ELSE
                            0
                        END) AS economic_abuse_count,
                    SUM(
                        CASE WHEN others_abuse_flag = 1 THEN
                            1
                        ELSE
                            0
                        END) AS others_abuse_count
        ")
        ->when($request->category == 'municipality', function ($q) use ($request) {
            $q->whereIn('municipality_code', explode(',', $request->code));
        })
        ->when($request->category == 'barangay', function ($q) use ($request) {
            $q->whereRaw('
                        CASE WHEN same_address_flag = 1 THEN
                            barangay_code IN(?)
                        WHEN same_address_flag = 0 THEN
                            intake_baranga_code IN(?)
                        END', [$request->code, $request->code]
            );
        })
        ->whereGender($patient_gender)
        ->whereBetween('case_date', [$request->start_date, $request->end_date])
        ->whereBetween('age',[$age_year_bracket1, $age_year_bracket2])
        ->groupBy('barangay_code', 'intake_barangay_code')
        ->orderBy('age', 'ASC');
    }
}
