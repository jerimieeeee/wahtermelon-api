<?php

namespace App\Services\Morbidity;

use Illuminate\Support\Facades\DB;

class MorbidityReportService
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

    public function get_morbidity_report_all($request)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                    icd10_desc AS description,
                    consult_notes_final_dxes.icd10_code AS icd10_code,
                    SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, birthdate) BETWEEN 0 AND 6)
                            AND patients.gender = 'M'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'Male 0 - 6 days',
                            SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, birthdate) BETWEEN 0 AND 6)
                            AND patients.gender = 'F'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'Female 0 - 6 days',
                     SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, birthdate) BETWEEN 7 AND 28)
                            AND patients.gender = 'M'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'Male 7 - 28 days',
                     SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, birthdate) BETWEEN 7 AND 28)
                            AND patients.gender = 'F'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'Female 7 - 28 days',
                    SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, birthdate) >= 29)
                            AND (TIMESTAMPDIFF(MONTH, birthdate, consult_date) <= 11)
                            AND patients.gender = 'M'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'Male 29 days - 11 months',
                    SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, birthdate) >= 29)
                            AND (TIMESTAMPDIFF(MONTH, birthdate, consult_date) <= 11)
                            AND patients.gender = 'F'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'Female 29 days - 11 months',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 1 AND 4)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 1 - 4 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 1 AND 4)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 1 - 4 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 5 AND 9)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 5 - 9 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 5 AND 9)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 5 - 9 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 10 AND 14)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 10 - 14 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 10 AND 14)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 10 - 14 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 15 AND 19)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 15 - 19 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 15 AND 19)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 15 - 19 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 20 AND 24)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 20 - 24 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 20 AND 24)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 20 - 24 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 25 AND 29)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 25 - 29 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 25 AND 29)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 25 - 29 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 30 AND 34)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 30 - 34 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 30 AND 34)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 30 - 34 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 35 AND 39)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 35 - 39 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 35 AND 39)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 35 - 39 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 40 AND 44)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 40 - 44 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 40 AND 44)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 40 - 44 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 45 AND 49)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 45 - 49 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 45 AND 49)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 45 - 49 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 50 AND 54)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 50 - 54 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 50 AND 54)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 50- 54 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 55 AND 59)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 55 - 59 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 55 AND 59)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 55- 59 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 60 AND 64)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 60 - 64 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 60 AND 64)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 60- 64 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 65 AND 69)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 65 - 69 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) BETWEEN 65 AND 69)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 65- 69 years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) >= 70)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Male 70 above',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) >= 70)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Female 70 above',
                    SUM(
                        CASE
                        WHEN patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Grand Total Male',
                    SUM(
                        CASE
                        WHEN patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Grand Total Female',
                    SUM(
                        CASE
                        WHEN patients.gender IN('F', 'M')
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'Grand Total both sex'
                ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
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
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->groupBy('consult_notes_final_dxes.icd10_code')
            ->orderBy('icd10_desc', 'ASC');
    }
}
