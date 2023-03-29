<?php

namespace App\Services\MaternalCare;

use Illuminate\Support\Facades\DB;

class MaternalCareReportService
{
    public function get_all_brgy_municipalities_patient()
    {
        return DB::table('municipalities')
            ->selectRaw('
                        patient_id,
                        municipalities.code AS municipality_code,
                        barangays.code AS barangay_code
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.code', 'barangays.code');
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
                      DATE_FORMAT(GROUP_CONCAT(DISTINCT delivery_date), '%Y-%m-%d') AS date_of_service,
                      TIMESTAMPDIFF(YEAR, birthdate, GROUP_CONCAT(DISTINCT delivery_date)) AS age_year,
                      municipalities_brgy.municipality_code AS municipality_code,
                      municipalities_brgy.barangay_code AS barangay_code
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
                        DATE_FORMAT(date_of_service, '%Y-%m-%d') AS date_of_service,
                        age_year,
                        municipality_code,
                        barangay_code
            ")
            ->when(isset($request->municipality_code), function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->municipality_code));
            })
            ->when(isset($request->barangay_code), function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->barangay_code));
            })
            ->whereYear('date_of_service', $request->year)
            ->whereMonth('date_of_service', $request->month)
            ->groupBy('name', 'date_of_service', 'age_year', 'municipality_code', 'barangay_code')
            ->havingRaw('(trimester1_count >= 1 AND trimester2_count >= 1 AND trimester3_count >= 2) AND (age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_assessed_nutrition($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_prenatals')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    birthdate,
	                    prenatal_date AS date_of_service,
	                    trimester,
	                    TIMESTAMPDIFF(YEAR, birthdate, GROUP_CONCAT(prenatal_date)) AS age_year,
	                    municipality_code,
	                    barangay_code
                    ")
            ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_prenatals.patient_id');
            })
            ->when(isset($request->municipality_code), function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->municipality_code));
            })
            ->when(isset($request->barangay_code), function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->barangay_code));
            })
            ->whereNotNull('patient_weight')
            ->where('patient_weight', '!=', 0)
            ->whereNotNull('patient_height')
            ->where('patient_height', '!=', 0)
            ->whereTrimester('1')
            ->whereYear('prenatal_date', $request->year)
            ->whereMonth('prenatal_date', $request->month)
            ->groupBy('name', 'prenatal_date', 'trimester', 'birthdate', 'municipality_code', 'barangay_code')
            ->havingRaw('trimester = 1 AND (age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_assessed_bmi($request, $bmi_status, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                            consult_mc_prenatals.patient_id,
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            ROUND(patient_weight / POWER((patient_height / 100), 2), 1) AS bmi,
                            prenatal_date AS date_of_service,
                            trimester,
                            birthdate,
                            municipality_code,
                            barangay_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_prenatals.patient_id');
                })
                ->when(isset($request->municipality_code), function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->municipality_code));
                })
                ->when(isset($request->barangay_code), function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->barangay_code));
                })
                ->groupBy('consult_mc_prenatals.patient_id', 'prenatal_date', 'patient_weight', 'patient_height', 'trimester', 'municipality_code', 'barangay_code');
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
                        TIMESTAMPDIFF(YEAR, birthdate,  SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(date_of_service ORDER BY date_of_service DESC), ',', 1), ',', - 1)) AS age_year,
                        municipality_code,
                        barangay_code
            ")
            ->groupBy('name', 'bmi', 'birthdate', 'trimester', 'municipality_code', 'barangay_code')
            ->when(isset($request->municipality_code), function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->municipality_code));
            })
            ->when(isset($request->barangay_code), function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->barangay_code));
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

    public function pregnant_td_vaccine($request, $vaccine, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            birthdate,
                            vaccine_date AS date_of_service,
                            vaccine_id,
                            status_id,
                            ROW_NUMBER() OVER (PARTITION BY patients.id,
                                vaccine_id ORDER BY vaccine_id) AS vaccine_seq,
                            municipality_code,
                            barangay_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->join('patient_vaccines', 'consult_mc_prenatals.patient_id', '=', 'patient_vaccines.patient_id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_prenatals.patient_id');
                })
                ->when(isset($request->municipality_code), function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->municipality_code));
                })
                ->when(isset($request->barangay_code), function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->barangay_code));
                })
                ->whereVaccineId('TD')
                ->groupBy('consult_mc_prenatals.patient_id', 'vaccine_id', 'vaccine_date', 'status_id', 'municipality_code', 'barangay_code');
        })
            ->selectRaw('
                        name,
                        birthdate,
                        date_of_service,
                        vaccine_id,
                        status_id,
                        vaccine_seq,
                        TIMESTAMPDIFF(YEAR, birthdate, date_of_service) AS age_year,
                        municipality_code,
                        barangay_code
            ')
            ->groupBy('name', 'date_of_service', 'age_year', 'municipality_code', 'barangay_code', 'birthdate', 'vaccine_id', 'status_id')
            ->when($vaccine == 'TD2', function ($query) use ($request, $age_year_bracket1, $age_year_bracket2) {
                $query->havingRaw('(vaccine_seq = 2 AND status_id = 1) AND YEAR(date_of_service) = ? AND MONTH(date_of_service) = ? AND (age_year BETWEEN ? AND ?)', [$request->year, $request->month, $age_year_bracket1, $age_year_bracket2]);
            })
            ->when($vaccine == 'TD3', function ($query) use ($request, $age_year_bracket1, $age_year_bracket2) {
                $query->havingRaw('(vaccine_seq >= 3 AND status_id = 1) AND YEAR(date_of_service) = ? AND MONTH(date_of_service) = ? AND (age_year BETWEEN ? AND ?)', [$request->year, $request->month, $age_year_bracket1, $age_year_bracket2]);
            })
            ->orderBy('name', 'ASC');
    }

    public function pregnant_mc_services_with_qty($request, $service, $quantity, $visit, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request, $service, $quantity, $visit) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        (
                          SELECT
                             MIN(service_date)
                          FROM (
                                SELECT
                                    service_date,
                                    @qty := @qty + service_qty AS cumulative_qty
                                FROM
                                    consult_mc_services
                                CROSS JOIN (
                                    SELECT
                                        @qty := 0) q
                                WHERE
                                    patient_id = patients.id
                                    AND service_id = ?
                                    AND visit_status = ?
                                ORDER BY
                                    service_date ASC) AS t
                            WHERE
                                cumulative_qty >= ?
                            LIMIT 1) AS date_of_service,
                        service_id,
                        SUM(service_qty) AS total_service_qty,
                        municipality_code,
                        barangay_code
                    ", [$service, $visit, $quantity])
                ->from('consult_mc_services')
                ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_services.patient_id');
                })
                ->when(isset($request->municipality_code), function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->municipality_code));
                })
                ->when(isset($request->barangay_code), function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->barangay_code));
                })
                ->groupBy('name', 'consult_mc_services.patient_id', 'birthdate', 'service_id', 'municipality_code', 'barangay_code')
                ->whereVisitStatus($visit)
                ->whereServiceId($service);
        })
            ->selectRaw('
                        name,
                        birthdate,
                        date_of_service,
                        service_id,
                        total_service_qty,
                        TIMESTAMPDIFF(YEAR, birthdate, date_of_service) AS age_year,
                        municipality_code,
                        barangay_code
            ')
            ->havingRaw('(total_service_qty >= ?) AND (age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$quantity, $age_year_bracket1, $age_year_bracket2, $request->year, $request->month]);
    }

    public function pregnant_test($class, $class2, $request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        service_date AS date_of_service,
                        service_id,
                        positive_result,
                        visit_status,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_services.patient_id');
            })
            ->when(isset($request->municipality_code), function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->municipality_code));
            })
            ->when(isset($request->barangay_code), function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->barangay_code));
            })
            ->when($class == $class, fn ($query) => $query->whereServiceId($class2)
                           ->whereVisitStatus('Prenatal')
                           ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->when($class == $class, fn ($query) => $query->whereServiceId($class2)
                       ->wherePositiveResult('1')
                       ->whereVisitStatus('Prenatal')
                       ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->orderBy('name', 'ASC');
    }

/*    public function get_no_of_births($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                        outcome_code,
                        TIMESTAMPDIFF(YEAR, birthdate, delivery_date) AS age_year
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->whereIn('outcome_code', ['FDU', 'FDUF', 'LSCF', 'LSCM', 'NSDF', 'NSDM', 'SB', 'SBF', 'TWIN'])
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_livebirths($request, $gender, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                        outcome_code,
                        TIMESTAMPDIFF(YEAR, birthdate, delivery_date) AS age_year
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->when($gender == 'MALE',  fn($query) =>
                     $query->whereIn('outcome_code', ['LSCM', 'NSDM'])
                           ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->when($gender == 'FEMALE',  fn($query) =>
            $query->whereIn('outcome_code', ['LSCF', 'NSDF'])
                ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            )
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_deliveries_professional($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                        attendant_code,
                        TIMESTAMPDIFF(YEAR, birthdate, delivery_date) AS age_year
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->whereIn('attendant_code', ['MD', 'MW', 'RN'])
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }*/

    public function post_partum_2_checkup($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_postparta')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        postpartum_date AS date_of_service,
                        visit_sequence,
                        TIMESTAMPDIFF(YEAR, birthdate, postpartum_date) AS age_year,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_mc_postparta.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_postparta.patient_id');
            })
            ->when(isset($request->municipality_code), function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->municipality_code));
            })
            ->when(isset($request->barangay_code), function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->barangay_code));
            })
            ->whereVisitSequence('2')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function post_partum_vitamin_a($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
	                    service_date AS date_of_service,
                        service_id,
                        visit_status,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_mc_services.patient_id');
            })
            ->when(isset($request->municipality_code), function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->municipality_code));
            })
            ->when(isset($request->barangay_code), function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->barangay_code));
            })
            ->whereServiceId('VITA')
            ->whereVisitStatus('Postpartum')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }
}
