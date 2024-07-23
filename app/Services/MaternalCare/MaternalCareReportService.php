<?php

namespace App\Services\MaternalCare;

use Illuminate\Support\Facades\DB;

class MaternalCareReportService
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
            ->leftJoin('barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
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
            ->selectRaw('
                        patient_id,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
//            ->join('patients', 'household_members.patient_id', '=', 'patients.id');
//            ->groupBy('patient_id', 'municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_4prenatal_give_birth($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                      CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                      SUM(
                        CASE WHEN trimester = 1 THEN
                            1
                        ELSE
                            NULL
                        END) AS trimester1,
                      SUM(
                        CASE WHEN trimester = 2 THEN
                            1
                        ELSE
                            NULL
                        END) AS trimester2,
                      SUM(
                        CASE WHEN trimester = 3 THEN
                            1
                        ELSE
                            NULL
                        END) AS trimester3,
                      birthdate,
                      DATE_FORMAT(GROUP_CONCAT(DISTINCT delivery_date), '%Y-%m-%d') AS date_of_service,
                      TIMESTAMPDIFF(YEAR, birthdate, GROUP_CONCAT(DISTINCT delivery_date)) AS age_year,
                      municipalities_brgy.municipality_code AS municipality_code,
                      municipalities_brgy.barangay_code AS barangay_code,
                      consult_mc_prenatals.facility_code AS facility_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->join('patient_mc', 'patients.id', '=', 'patient_mc.patient_id')
                ->join('patient_mc_post_registrations', 'patient_mc.id', '=', 'patient_mc_post_registrations.patient_mc_id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_prenatals.patient_id');
                })
                ->whereIn('trimester', [1, 2, 3])
                ->groupBy('consult_mc_prenatals.patient_id', 'municipality_code', 'barangay_code');
        })
            ->selectRaw("
                        name,
                        SUM(trimester1) AS trimester1_count,
                        SUM(trimester2) AS trimester2_count,
                        SUM(trimester3) AS trimester3_count,
                        birthdate,
                        DATE_FORMAT(date_of_service, '%Y-%m-%d') AS date_of_service,
                        age_year
            ")
//            ->when($request->category == 'all', function ($q) {
//                $q->where('facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->where('facility_code', auth()->user()->facility_code)
            ->whereYear('date_of_service', $request->year)
            ->whereMonth('date_of_service', $request->month)
            ->groupBy('name', 'birthdate', 'date_of_service', 'age_year', 'municipality_code', 'barangay_code')
            ->havingRaw('(trimester1_count >= 1 AND trimester2_count >= 1 AND trimester3_count >= 2) AND (age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_assessed_nutrition($request, $bmi_status, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            ROUND(patient_weight / POWER((patient_height / 100), 2), 1) AS bmi,
                            prenatal_date AS date_of_service,
                            trimester,
                            birthdate,
                            municipality_code,
                            barangay_code,
                            consult_mc_prenatals.facility_code AS facility_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_prenatals.patient_id');
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->code));
                });
        })
            ->selectRaw("
                        name,
                        bmi,
                        CASE WHEN bmi BETWEEN 18.5 AND 22.9 THEN
                            'NORMAL'
                        WHEN bmi >= 23 THEN
                            'HIGH'
                        WHEN bmi < 18.5 THEN
                            'LOW'
                        ELSE
                            NULL
                        END AS bmi_status,
                        birthdate,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(date_of_service ORDER BY date_of_service DESC), ',', 1), ',', - 1) AS date_of_service,
                        trimester,
                        TIMESTAMPDIFF(YEAR, birthdate,  SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(date_of_service ORDER BY date_of_service DESC), ',', 1), ',', - 1)) AS age_year
            ")
            ->where('facility_code', auth()->user()->facility_code)
            ->whereYear('date_of_service', $request->year)
            ->whereMonth('date_of_service', $request->month)
            ->groupBy('name', 'bmi', 'birthdate', 'trimester', 'municipality_code', 'barangay_code')
//            ->when($request->category == 'all', function ($q) {
//                $q->where('facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->when($bmi_status == 'NORMAL', function ($query) use ($age_year_bracket1, $age_year_bracket2) {
                $query->havingRaw("(bmi_status = 'NORMAL' AND trimester = 1) AND (age_year BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2]);
            })
            ->when($bmi_status == 'HIGH', function ($query) use ($age_year_bracket1, $age_year_bracket2) {
                $query->havingRaw("(bmi_status = 'HIGH' AND trimester = 1) AND (age_year BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2]);
            })
            ->when($bmi_status == 'LOW', function ($query) use ($age_year_bracket1, $age_year_bracket2) {
                $query->havingRaw("(bmi_status = 'LOW' AND trimester = 1) AND (age_year BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2]);
            });
    }

    public function pregnant_assessed_bmi($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            ROUND(patient_weight / POWER((patient_height / 100), 2), 1) AS bmi,
                            prenatal_date AS date_of_service,
                            trimester,
                            birthdate,
                            municipality_code,
                            barangay_code,
                            consult_mc_prenatals.facility_code AS facility_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_prenatals.patient_id');
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->code));
                });
//                ->groupBy('consult_mc_prenatals.patient_id', 'prenatal_date', 'patient_weight', 'patient_height', 'trimester', 'municipality_code', 'barangay_code');
        })
            ->selectRaw("
                        name,
                        CASE WHEN bmi BETWEEN 18.5 AND 22.9 THEN
                            'NORMAL'
                        WHEN bmi >= 23 THEN
                            'HIGH'
                        WHEN bmi < 18.5 THEN
                            'LOW'
                        ELSE
                            NULL
                        END AS bmi_status,
                        birthdate,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(date_of_service ORDER BY date_of_service DESC), ',', 1), ',', - 1) AS date_of_service,
                        trimester,
                        TIMESTAMPDIFF(YEAR, birthdate,  SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(date_of_service ORDER BY date_of_service DESC), ',', 1), ',', - 1)) AS age_year
            ")
            ->where('facility_code', auth()->user()->facility_code)
            ->whereYear('date_of_service', $request->year)
            ->whereMonth('date_of_service', $request->month)
            ->groupBy('name', 'bmi', 'birthdate', 'trimester', 'municipality_code', 'barangay_code')
//            ->when($request->category == 'all', function ($q) {
//                $q->where('facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->havingRaw("(bmi_status IN ('HIGH', 'NORMAL', 'LOW') AND trimester = 1) AND (age_year BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_td2_vaccine($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request, $age_year_bracket1, $age_year_bracket2) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            birthdate,
                            vaccine_date AS date_of_service,
                            (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date) AS vaccine_seq
                ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->join('patient_mc', 'patient_vaccines.patient_id', '=', 'patient_mc.patient_id')
                ->join('patient_mc_pre_registrations', 'patient_mc.id', '=', 'patient_mc_pre_registrations.patient_mc_id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
                })
//                ->when($request->category == 'all', function ($q) {
//                    $q->where('patient_vaccines.facility_code', auth()->user()->facility_code);
//                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->where('patient_vaccines.facility_code', auth()->user()->facility_code)
                ->whereInitialGravidity(1)
                ->whereVaccineId('TD')
                ->whereStatusId('1')
                ->whereRaw('TIMESTAMPDIFF(YEAR, birthdate, vaccine_date) BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2])
//                ->groupBy('patient_vaccines.patient_id')
                ->havingRaw('vaccine_seq = 2 AND YEAR(date_of_service) = ? AND MONTH(date_of_service) = ?', [$request->year, $request->month])
                ->orderBy('name', 'ASC');
        });
    }

    public function pregnant_td3_vaccine($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request, $age_year_bracket1, $age_year_bracket2) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            birthdate,
                            vaccine_date AS date_of_service,
                            (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date) AS vaccine_seq
                ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->join('patient_mc', 'patient_vaccines.patient_id', '=', 'patient_mc.patient_id')
                ->join('patient_mc_pre_registrations', 'patient_mc.id', '=', 'patient_mc_pre_registrations.patient_mc_id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
                })
//                ->when($request->category == 'all', function ($q) {
//                    $q->where('patient_vaccines.facility_code', auth()->user()->facility_code);
//                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->where('patient_vaccines.facility_code', auth()->user()->facility_code)
                ->whereInitialGravidity(1)
                ->whereVaccineId('TD')
                ->whereStatusId('1')
                ->whereRaw('TIMESTAMPDIFF(YEAR, birthdate, vaccine_date) BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2])
//                ->groupBy('patient_vaccines.patient_id')
                ->havingRaw('vaccine_seq IN (3,4,5) AND YEAR(date_of_service) = ? AND MONTH(date_of_service) = ?', [$request->year, $request->month])
                ->orderBy('name', 'ASC');
        });
    }

    public function get_service($request, $service, $visit)
    {
        return DB::table(function ($query) use ($request, $service, $visit) {
            $query->selectRaw("
                        patient_mc_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        service_id,
                        GROUP_CONCAT(DATE_FORMAT(service_date, '%Y-%m') ORDER BY service_date ASC) AS service_dates,
                        GROUP_CONCAT(DATE_FORMAT(service_date, '%Y-%m-%d') ORDER BY service_date ASC) AS date,
                        GROUP_CONCAT(service_qty ORDER BY service_date ASC) AS service_qty,
                        GROUP_CONCAT(TIMESTAMPDIFF(YEAR, birthdate, DATE_FORMAT(service_date, '%Y-%m-%d')) ORDER BY service_date ASC) AS age_year
		            ")
                ->from('consult_mc_services')
                ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_services.patient_id');
                })
//                ->when($request->category == 'all', function ($q) {
//                    $q->where('consult_mc_services.facility_code', auth()->user()->facility_code);
//                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->code));
                })
                ->where('consult_mc_services.facility_code', auth()->user()->facility_code)
                ->whereVisitStatus($visit)
                ->whereServiceId($service)
                ->groupBy('patient_mc_id');
        });
    }

    public function pregnant_test($is_positive, $service, $request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        service_date AS date_of_service,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_services.patient_id');
            })
//            ->when($request->category == 'all', function ($q) {
//                $q->where('consult_mc_services.facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->where('consult_mc_services.facility_code', auth()->user()->facility_code)
            ->when($is_positive == 'N', fn ($query) => $query->whereServiceId($service)
                ->whereVisitStatus('Prenatal')
                ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->when($is_positive == 'Y', fn ($query) => $query->whereServiceId($service)
                ->wherePositiveResult('1')
                ->whereVisitStatus('Prenatal')
                ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->orderBy('name', 'ASC');
    }

    public function post_partum_2_checkup($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_postparta')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        postpartum_date AS date_of_service,
                        TIMESTAMPDIFF(YEAR, birthdate, postpartum_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_postparta.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_postparta.patient_id');
            })
//            ->when($request->category == 'all', function ($q) {
//                $q->where('consult_mc_postparta.facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('consult_mc_postparta.facility_code', auth()->user()->facility_code)
            ->whereVisitSequence(2)
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_deliveries($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, delivery_date) AS age_year
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->leftJoin('facilities', 'patient_mc_post_registrations.barangay_code', '=', 'facilities.barangay_code')
//            ->when($request->category == 'all', function ($q) {
//                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('facilities.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code)
            ->whereIn('outcome_code', ['FDU', 'FDUF', 'LSCF', 'LSCSM', 'NSDF', 'NSDM', 'SB', 'SBF', 'TWIN'])
            ->groupBy('patient_id', 'delivery_date', 'outcome_code')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_livebirths($request, $gender)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code)
            ->when($gender == 'ALL', fn ($query) => $query->whereIn('outcome_code', ['LSCM', 'NSDM', 'LSCF', 'NSDF'])
            )
            ->when($gender == 'MALE', fn ($query) => $query->whereIn('outcome_code', ['LSCM', 'NSDM'])
            )
            ->when($gender == 'FEMALE', fn ($query) => $query->whereIn('outcome_code', ['LSCF', 'NSDF'])
            )
            ->whereYear('delivery_date', $request->year)
            ->whereMonth('delivery_date', $request->month)
            ->groupBy('patient_id', 'delivery_date', 'outcome_code', 'barangays.psgc_10_digit_code', 'patient_mc_post_registrations.barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_livebirths_by_weight($request, $weight)
    {
        return DB::table('patient_ccdevs')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        birthdate AS date_of_service,
                        patient_ccdevs.birth_weight AS birth_weight
                    ")
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->join('patient_mc', 'patient_ccdevs.mothers_id', '=', 'patient_mc.patient_id')
            ->join('patient_mc_post_registrations', 'patient_mc.id', '=', 'patient_mc_post_registrations.patient_mc_id')
            ->join('facilities', 'patient_mc_post_registrations.barangay_code', '=', 'facilities.barangay_code')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_ccdevs.patient_id');
            })
//            ->when($request->category == 'all', function ($q) {
//                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
//            })
            ->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code)
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->when($weight == 'NORMAL', fn ($query) => $query->where('patient_ccdevs.birth_weight', '>=', 2.5)
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($weight == 'LOW', fn ($query) => $query->where('patient_ccdevs.birth_weight', '<', 2.5)
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($weight == 'UNKNOWN', fn ($query) => $query->where('patient_ccdevs.birth_weight', 0)
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->groupBy('patient_ccdevs.patient_id')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_deliveries_professional($request, $attendant)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code)
            ->when($attendant == 'ALL', fn ($query) => $query->whereIn('attendant_code', ['MD', 'MW', 'RN'])
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($attendant == 'DOCTOR', fn ($query) => $query->whereAttendantCode('MD')
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($attendant == 'NURSE', fn ($query) => $query->whereAttendantCode('RN')
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($attendant == 'MIDWIFE', fn ($query) => $query->whereAttendantCode('MW')
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->groupBy('patient_id')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_deliveries_health_facility($request, $facility)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                        delivery_location_code
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code)
            ->when($facility == 'ALL', fn ($query) => $query->whereIn('delivery_location_code', ['BHS', 'DOHAM', 'HC', 'HOSP', 'HOSPP', 'LYIN', 'LYINP'])
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($facility == 'PUBLIC-HF', fn ($query) => $query->whereIn('delivery_location_code', ['BHS', 'HC', 'HOSP', 'LYINP', 'DOHAM'])
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($facility == 'PRIVATE-HF', fn ($query) => $query->whereIn('delivery_location_code', ['HOSPP', 'LYIN'])
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($facility == 'NON-HF', fn ($query) => $query->whereIn('delivery_location_code', ['OTHERS', 'HOME'])
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->groupBy('patient_id')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_type_of_delivery_all($request, $delivery)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                        outcome_code
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code)
            ->when($delivery == 'ALL', fn ($query) => $query->whereIn('outcome_code', ['LSCSF', 'LSCSM', 'NSDF', 'NSDM'])
                ->havingRaw('year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->groupBy('patient_id')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_type_of_delivery_nsd_cs($request, $delivery, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, delivery_date) AS age_year,
                        outcome_code
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code)
            ->when($delivery == 'NSD', fn ($query) => $query->whereIn('outcome_code', ['NSDF', 'NSDM'])
                ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->when($delivery == 'CS', fn ($query) => $query->whereIn('outcome_code', ['LSCSF', 'LSCSM'])
                ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->groupBy('patient_id')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_pregnancy_outcome_all($request)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                    CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                    patients.birthdate AS birthdate,
                    lmp_date,
                    DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                    CASE
                        WHEN FLOOR((DATEDIFF(delivery_date, lmp_date)) / 7) BETWEEN 37 AND 42 THEN 'full_term'
                        WHEN FLOOR((DATEDIFF(delivery_date, lmp_date)) / 7) BETWEEN 22 AND 36 THEN 'pre_term'
                        ELSE NULL
                    END AS status,
                    outcome_code,
                    patient_mc_post_registrations.facility_code AS facility_code,
                    pregnancy_termination_date,
                    pregnancy_termination_code,
                    municipalities.psgc_10_digit_code AS municipality_code,
                    patient_mc_post_registrations.barangay_code AS barangay_code
                ")
                ->from('patient_mc_post_registrations')
                ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
                ->join('patient_mc_pre_registrations', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc_pre_registrations.patient_mc_id')
                ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
                ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->groupBy('status', 'date_of_service', 'patient_mc_post_registrations.delivery_date', 'birthdate', 'name', 'lmp_date', 'outcome_code', 'pregnancy_termination_date', 'pregnancy_termination_code');
        })
            ->selectRaw('
                        *
            ')
//            ->when($request->category == 'all', function ($q) {
//                $q->where('facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->where('facility_code', auth()->user()->facility_code)
            ->whereIn('status', ['full_term', 'pre_term'])
            ->whereIn('outcome_code', ['FDU', 'FDUF', 'SB', 'SBF'])
            ->whereIn('pregnancy_termination_code', ['SPON', 'IND'])
            ->havingRaw('(year(date_of_service) = ? AND month(date_of_service)) = ? OR year(pregnancy_termination_date) = ? AND month(pregnancy_termination_date) = ?', [$request->year, $request->month, $request->year, $request->month])
            ->groupBy('birthdate', 'status', 'name', 'lmp_date', 'date_of_service', 'outcome_code', 'pregnancy_termination_date', 'pregnancy_termination_code')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_pregnancy_outcome($request, $status, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                    CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                    patients.birthdate AS birthdate,
                    lmp_date,
                    DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                    TIMESTAMPDIFF(YEAR, patients.birthdate, delivery_date) AS age_year,
                    CASE
                        WHEN FLOOR((DATEDIFF(delivery_date, lmp_date)) / 7) BETWEEN 37 AND 42 THEN 'full_term'
                        WHEN FLOOR((DATEDIFF(delivery_date, lmp_date)) / 7) BETWEEN 22 AND 36 THEN 'pre_term'
                        ELSE NULL
                    END AS status,
                    outcome_code,
                    patient_mc_post_registrations.facility_code AS facility_code,
                    pregnancy_termination_date,
                    pregnancy_termination_code,
                    municipalities.psgc_10_digit_code AS municipality_code,
                    patient_mc_post_registrations.barangay_code AS barangay_code
                ")
                ->from('patient_mc_post_registrations')
                ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
                ->join('patient_mc_pre_registrations', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc_pre_registrations.patient_mc_id')
                ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
                ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->groupBy('status', 'date_of_service', 'patient_mc_post_registrations.delivery_date', 'birthdate', 'name', 'lmp_date', 'outcome_code', 'pregnancy_termination_date', 'pregnancy_termination_code');
            })
            ->selectRaw('
                        *
            ')
//            ->when($request->category == 'all', function ($q) {
//                $q->where('facility_code', auth()->user()->facility_code);
//            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->where('facility_code', auth()->user()->facility_code)
            ->groupBy('name', 'date_of_service', 'age_year', 'municipality_code', 'barangay_code')
            ->when($status == 'FULL-TERM', fn ($query) => $query->havingRaw('status = ? AND (age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', ['full_term', $age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->when($status == 'PRE-TERM', fn ($query) => $query->havingRaw('status = ? AND (age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', ['pre_term', $age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->when($status == 'FETAL-DEATH', fn ($query) => $query->whereIn('outcome_code', ['FDU', 'FDUF', 'SB', 'SBF'])
                ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->when($status == 'ABORTION', fn ($query) => $query->whereIn('pregnancy_termination_code', ['SPON', 'IND'])
                ->havingRaw('(age_year BETWEEN ? AND ?) AND year(pregnancy_termination_date) = ? AND month(pregnancy_termination_date) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->groupBy('birthdate', 'status', 'name', 'lmp_date', 'date_of_service', 'outcome_code', 'pregnancy_termination_date', 'pregnancy_termination_code')
            ->orderBy('name', 'ASC');
    }
}
