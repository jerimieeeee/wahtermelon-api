<?php

namespace App\Services\Childcare;

use Illuminate\Support\Facades\DB;

class ChildCareReportService
{
    public function get_morbidity_report($request, $patient_gender, $vaccine_seq, $age_year)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            CONCAT(household_folders.address, ',', ' ', barangays.name) AS barangay_name,
                            birthdate,
                            consult_date,
                            consult_notes_final_dxes.icd10_code AS icd10_code,
                            icd10_desc,
                            TIMESTAMPDIFF(YEAR, birthdate, consult_date) AS year,
                            TIMESTAMPDIFF(MONTH, birthdate, consult_date) % 12 AS month,
                            FLOOR(TIMESTAMPDIFF(DAY, birthdate, consult_date) % 29) AS day
                    ")
                ->from('consult_notes_final_dxes')
                ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
                ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
                ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
                ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
                ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
                ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
                ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->code));
                })
                ->whereVaccineId('IPV')
                ->whereGender($patient_gender)
                ->whereStatusId('1');
        })
            ->selectRaw('
                        name,
                        birthdate,
                        date_of_service,
                        vaccine_seq,
                        TIMESTAMPDIFF(YEAR, birthdate, date_of_service) AS age_year,
                        municipality_code,
                        barangay_code
            ')
            ->havingRaw('(vaccine_seq = ?) AND (age_year = ?) AND (year(date_of_service) = ? AND month(date_of_service) = ?)', [$vaccine_seq, $age_year, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }
}
