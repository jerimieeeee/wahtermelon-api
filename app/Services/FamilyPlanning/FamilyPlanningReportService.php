<?php

namespace App\Services\FamilyPlanning;

use Illuminate\Support\Facades\DB;

class FamilyPlanningReportService
{
    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code,
                        name AS barangay_name,
                        year,
                        settings_catchment_barangays.population,
                        (SELECT SUM(population) FROM settings_catchment_barangays) AS total_population
                    ')
            ->leftJoin('barangays', 'barangays.code', '=', 'settings_catchment_barangays.barangay_code')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code', 'barangay_code', 'year', 'population');
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
            ->selectRaw("
                        patient_id,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        municipalities.code AS municipality_code,
                        barangays.code AS barangay_code
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.code', 'barangays.code');
    }

    public function get_fp_report($request)
    {
        return DB::table('patient_ccdevs')
            ->selectRaw("
                        method_code,
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14 AND
                                IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ?-1, MONTH(enrollment_date) = ?-1 AND YEAR(enrollment_date) = ?)
                            THEN 1
                            ELSE 0
                            END) AS 'New Acceptor (Previous Month) - 10 to 14'),
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'New Acceptor (Present Month) - 10 to 14'),
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19 AND
                                IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ?-1, MONTH(enrollment_date) = ?-1 AND YEAR(enrollment_date) = ?)
                                THEN 1
                                ELSE 0
                            END) AS 'New Acceptor (Previous Month) - 15 to 19'),
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'New Acceptor (Present Month) - 15 to 19'),
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49 AND
                                IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ?-1, MONTH(enrollment_date) = ?-1 AND YEAR(enrollment_date) = ?)
                                THEN 1
                                ELSE 0
                            END) AS 'New Acceptor (Previous Month) - 20 to 49'),
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'New Acceptor (Present Month) - 20 to 49'),
                        SUM(CASE
                            WHEN
                                client_code IN('CC', 'CM', 'RS') AND
                            TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14 AND
                            MONTH(enrollment_date) = ? AND
                            YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'Other Acceptor (Present Month) - 10 to 14'),
                        SUM(CASE
                                WHEN
                                    client_code IN('CC', 'CM', 'RS') AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'Other Acceptor (Present Month) - 15 to 19'),
                        SUM(CASE
                            WHEN
                                client_code IN('CC', 'CM', 'RS') AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'Other Acceptor (Present Month) - 20 to 49')",
                [
                //BINDINGS FOR New Acceptor (Previous Month) - 10 to 14
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Present Month) - 10 to 14
                $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Previous Month) - 15 to 19
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Present Month) - 15 to 19
                $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Previous Month) - 20 to 49
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Present Month) - 20 to 49
                $request->month, $request->year,

                //BINDINGS FOR Other Acceptor (Present Month) - 10 to 14
                $request->month, $request->year,

                //BINDINGS FOR Other Acceptor (Present Month) - 15 to 19
                $request->month, $request->year,

                //BINDINGS FOR Other Acceptor (Present Month) - 20 to 49
                $request->month, $request->year
                ])
        ->join('patients', 'patient_fp_methods.patient_id', '=', 'patients.id')
        ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
            $join->on('municipalities_brgy.patient_id', '=', 'patient_fp_methods.patient_id');
        })
        ->when($request->category == 'all', function ($q) {
            $q->where('patient_fp_methods.facility_code', auth()->user()->facility_code);
        })
        ->when($request->category == 'facility', function ($q) {
            $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
        })
        ->when($request->category == 'municipality', function ($q) use ($request) {
            $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
        })
        ->when($request->category == 'barangay', function ($q) use ($request) {
            $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
        })
        ->groupBy('method_code');
    }
}
