<?php

namespace App\Services\GenderBasedViolence;

use Illuminate\Support\Facades\DB;

class GenderBasedViolenceReportService
{
        public function get_gbv_catalyst_report_abuses($request, $patient_gender, $age_year_bracket1, $age_year_bracket2, $type1, $type2)
    {
        return DB::table('municipalities')
            ->selectRaw("
                        age,
                        municipalities.name AS municipality_name,
                        barangays.name AS barangay_name,
                        IF({$type2} IS NULL, '0', {$type2}) AS {$type2}
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->leftJoinSub($this->get_gbv_report_abuses($request, $patient_gender, $age_year_bracket1, $age_year_bracket2, $type1, $type2), 'abuse', function ($join) {
                $join->on('abuse.barangay_code', '=', 'barangays.code');
            })
            ->when($request->category == 'municipality',  function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            });
    }

    public function get_gbv_report_abuses($request, $patient_gender, $age_year_bracket1, $age_year_bracket2, $type1, $type2)
    {
        return DB::table(function ($query) use ($request, $patient_gender, $age_year_bracket1, $age_year_bracket2, $type1, $type2) {
            $query->selectRaw("
                        gender,
                        case_date,
                        TIMESTAMPDIFF(YEAR, birthdate, case_date) AS age,
                        CASE WHEN same_address_flag = 1 THEN
                            household_folders.barangay_code
                        WHEN same_address_flag = 0 THEN
                            patient_gbv_intakes.barangay_code
                        END AS barangay_code,
                        {$type1}
                    ")
            ->from('patient_gbv_intakes')
            ->join('patients', 'patient_gbv_intakes.patient_id', '=', 'patients.id')
            ->leftJoin('barangays', 'patient_gbv_intakes.barangay_code', '=', 'barangays.code')
            ->leftJoin('household_members', 'patient_gbv_intakes.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->groupBy('birthdate', 'case_date', 'barangay_code', 'gender');
        })
            ->selectRaw("
                        gender,
                        case_date,
                        age,
                        barangay_code,
                        {$type2}
            ")
            ->whereGender($patient_gender)
            ->whereBetween('case_date', [$request->start_date, $request->end_date])
            ->havingRaw('age BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2]);
    }
}
