<?php

namespace App\Services\Morbidity;

use Illuminate\Support\Facades\DB;

class ReportMorbidityNameListService
{
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
            ->selectRaw("
                        patient_id,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
    }

    public function get_report_namelist($request)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        consult_notes.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        birthdate,
                        TIMESTAMPDIFF(YEAR, birthdate, consult_date)
                        ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->where('consult_notes_final_dxes.icd10_code',$request->icd10_code)
            ->when($request->date_type == 'days', function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATEDIFF(consult_date, birthdate)'), [$request->age1, $request->age2]);
            })
            ->when($request->date_type == 'years', function ($q) use ($request) {
                $q->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, birthdate, consult_date)'), [$request->age1, $request->age2]);
            })
            ->whereGender($request->gender)
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code)
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->orderBy('name');
    }
}
