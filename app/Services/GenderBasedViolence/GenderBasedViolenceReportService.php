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
                        barangays.name AS barangay_name,
                        municipalities.name AS municipality_name
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.code', 'barangays.code');
    }

    public function get_gbv_report_sexual_abuse($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_gbv_intakes')
            ->selectRaw("
                            TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
                            municipalities_brgy.barangay_name AS barangay_name,
                            municipalities_brgy.municipality_name AS municipality_name,
                            barangays.name AS intake_barangay_name,
                            SUM(sexual_abuse_flag) AS sexual_abuse_count
		            ")
            ->from('patient_gbv_intakes')
            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
            ->join('barangays', 'patient_gbv_intakes.barangay_code', 'barangays.code')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_gbv_intakes.patient_id');
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereRaw('
                            CASE WHEN same_address_flag = 1 THEN
                                municipalities_brgy.barangay_code IN(?)
                            WHEN same_address_flag = 0 THEN
                                patient_gbv_intakes.barangay_code IN(?)
                            END', [$request->code, $request->code]
                );
            })
            ->whereGender($patient_gender)
            ->whereBetween('case_date', [$request->start_date, $request->end_date])
            ->havingRaw('age BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2])
            ->groupBy('municipalities_brgy.barangay_code', 'patient_gbv_intakes.barangay_code')
            ->orderBy('age', 'ASC');
    }

    public function get_gbv_report_physical_abuse($request, $patient_gender, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_gbv_intakes')
            ->selectRaw("
                            gender,
                            TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
                            case_date,
                            municipalities_brgy.barangay_name AS barangay_name,
                            municipalities_brgy.municipality_name AS municipality_name,
                            barangays.name AS intake_barangay_name,
                            SUM(physical_abuse_flag) AS physical_abuse_count
		            ")
            ->from('patient_gbv_intakes')
            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
            ->join('barangays', 'patient_gbv_intakes.barangay_code', 'barangays.code')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_gbv_intakes.patient_id');
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereRaw('
                            CASE WHEN same_address_flag = 1 THEN
                                municipalities_brgy.barangay_code IN(?)
                            WHEN same_address_flag = 0 THEN
                                patient_gbv_intakes.barangay_code IN(?)
                            END', [$request->code, $request->code]
                );
            })
            ->whereGender($patient_gender)
            ->whereBetween('case_date', [$request->start_date, $request->end_date])
            ->havingRaw('age BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2])
            ->groupBy('municipalities_brgy.barangay_code', 'patient_gbv_intakes.barangay_code')
            ->orderBy('age', 'ASC');
    }
}
