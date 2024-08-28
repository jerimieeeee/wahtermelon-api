<?php

namespace App\Services\Mortality;

use Illuminate\Support\Facades\DB;

class MortalityReportService
{
    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                    year,
                    SUM(settings_catchment_barangays.population) AS total_population
                    ')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code');
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
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
    }

    public function get_mortality_natality($request)
    {
        return DB::table('patient_death_records')
            ->selectRaw("
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND death_type IN('ENEOD', 'INFD', 'MATD', 'MARTLY', 'NEOD', 'UDFD')
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND death_type IN('ENEOD', 'INFD', 'MATD', 'MARTLY', 'NEOD', 'UDFD')
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND death_type IN('ENEOD', 'INFD', 'MATD', 'MARTLY', 'NEOD', 'UDFD')
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_total_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND death_type = 'MATD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_maternal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND death_type = 'MATD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_maternal_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND death_type = 'MATD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_maternal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND death_type = 'UDFD'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, date_of_death) BETWEEN 0 AND 59
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_under_five_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND death_type = 'UDFD'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, date_of_death) BETWEEN 0 AND 59
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_under_five_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND death_type = 'UDFD'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, date_of_death) BETWEEN 0 AND 59
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_under_five_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND death_type = 'INFD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_infant_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND death_type = 'INFD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_infant_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND death_type = 'INFD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_infant_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND death_type = 'NEOD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_neonatal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND death_type = 'NEOD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_neonatal_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND death_type = 'NEOD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_neonatal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND outcome_code IN('FDU', 'SB')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_fetal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND outcome_code IN('FDUF', 'SBF')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_fetal_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND outcome_code IN('FDU', 'FDUF', 'SB', 'SBF')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_fetal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND death_type = 'ENEOD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_early_neonatal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND death_type = 'ENEOD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_early_neonatal_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND death_type = 'ENEOD'
                                AND date_of_death BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_early_neonatal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND outcome_code IN('FDU', 'SB')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) +
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND death_type = 'ENEOD'
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_perinatal_deaths',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND outcome_code IN('FDUF', 'SBF')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) +
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND death_type = 'ENEOD'
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'female_perinatal_deaths',
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND outcome_code IN('FDU', 'FDUF', 'SB', 'SBF')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) +
                        SUM(
                            CASE WHEN patients.gender IN('M', 'F')
                                AND death_type = 'ENEOD'
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_perinatal_deaths',
                        SUM(
                            CASE WHEN outcome_code IN('LSCSM', 'NSDM')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'live_births_male',
                        SUM(
                            CASE WHEN outcome_code IN('LSCSF', 'NSDF')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'live_births_female',
                        SUM(
                            CASE WHEN outcome_code IN('LSCSM', 'NSDM', 'LSCSF', 'NSDF')
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'live_births_male_female',
                        SUM(
                            CASE WHEN outcome_code IN('LSCSM', 'NSDM')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, date_of_death) BETWEEN 15 AND 19
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'live_births_15_19_male',
                        SUM(
                            CASE WHEN outcome_code IN('LSCSF', 'NSDF')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, date_of_death) BETWEEN 15 AND 19
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'live_births_15_19_female',
                        SUM(
                            CASE WHEN outcome_code IN('LSCSM', 'NSDM', 'LSCSF', 'NSDF')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, date_of_death) BETWEEN 15 AND 19
                                AND delivery_date BETWEEN ? AND ? THEN
                                1
                            ELSE
                                0
                            END) AS 'live_births_15_19_male_female'
                    ",
                    [
                    //BINDINGS FOR male_total_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_total_deaths
                     $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_total_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_maternal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_maternal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_maternal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_under_five_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_under_five_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_under_five_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_infant_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_infant_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_infant_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_neonatal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_neonatal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_neonatal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_fetal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_fetal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_fetal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_early_neonatal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_early_neonatal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_early_neonatal_deaths
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_perinatal_deaths
                    $request->start_date, $request->end_date,
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR female_perinatal_deaths
                    $request->start_date, $request->end_date,
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR male_female_perinatal_deaths
                    $request->start_date, $request->end_date,
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR live_births_male
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR live_births_female
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR live_births_male_female
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR live_births_15_19_male
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR live_births_15_19_female
                    $request->start_date, $request->end_date,

                    //BINDINGS FOR live_births_15_19_male_female
                    $request->start_date, $request->end_date,
                    ])
            ->join('patients', 'patient_death_records.patient_id', '=', 'patients.id')
            ->leftJoin('patient_mc', 'patient_death_records.patient_id', '=', 'patient_mc.patient_id')
            ->leftJoin('patient_mc_post_registrations', 'patient_mc.id', '=', 'patient_mc_post_registrations.patient_mc_id')
            ->join('users', 'patient_death_records.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_death_records.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_death_records.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            });
    }
}
