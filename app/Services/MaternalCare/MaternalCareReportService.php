<?php

namespace App\Services\MaternalCare;

use Illuminate\Support\Facades\DB;

class MaternalCareReportService
{
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
                      TIMESTAMPDIFF(YEAR, birthdate, GROUP_CONCAT(DISTINCT delivery_date)) AS age_year
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->join('patient_mc_post_registrations', 'consult_mc_prenatals.patient_mc_id', '=', 'patient_mc_post_registrations.patient_mc_id')
                ->whereIn('trimester', [1, 2, 3])
                ->groupBy('patient_id', 'consult_mc_prenatals.patient_mc_id', 'trimester');
        })
            ->selectRaw("
                        name,
                        SUM(trimester1) AS trimester1_count,
                        SUM(trimester2) AS trimester2_count,
                        SUM(trimester3) AS trimester3_count,
                        DATE_FORMAT(date_of_service, '%Y-%m-%d') AS date_of_service,
                        age_year
            ")
            ->whereYear('date_of_service', $request->year)
            ->whereMonth('date_of_service', $request->month)
            ->groupBy('name', 'date_of_service', 'age_year')
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
	                    TIMESTAMPDIFF(YEAR, birthdate, GROUP_CONCAT(prenatal_date)) AS age_year
                    ")
            ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
            ->whereNotNull('patient_weight')
            ->where('patient_weight', '!=', 0)
            ->whereNotNull('patient_height')
            ->where('patient_height', '!=', 0)
            ->whereTrimester('1')
            ->whereYear('prenatal_date', $request->year)
            ->whereMonth('prenatal_date', $request->month)
            ->groupBy('name', 'prenatal_date', 'trimester', 'birthdate')
            ->havingRaw('trimester = 1 AND (age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }


    public function pregnant_normal_bmi($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use($request) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            ROUND(patient_weight / POWER((patient_height / 100), 2), 1) AS bmi,
                            GROUP_CONCAT(DATE_FORMAT(prenatal_date, '%Y-%m-%d')) AS prenatal_date,
                            trimester,
                            birthdate,
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->whereTrimester('1')
                ->whereYear('prenatal_date', $request->year)
                ->whereMonth('prenatal_date', $request->month)
                ->groupBy('patient_id', 'patient_weight', 'patient_height', 'trimester');
        })
            ->selectRaw("
                        name,
                        CASE WHEN bmi BETWEEN 18.5
                            AND 22.9 THEN
                            'NORMAL'
                        ELSE
                            NULL
                        END AS bmi_status,
                        birthdate,
                        SUBSTRING_INDEX(prenatal_date, ',', - 1) AS date_of_service,
                        trimester
            ")
            ->groupBy('name', 'bmi', 'date_of_service', 'trimester', 'birthdate')
            ->havingRaw('(bmi_status = Normal AND trimester = 1) AND (age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_low_bmi($request, $bmi_status, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                    CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                    ROUND(patient_weight / POWER((patient_height / 100), 2), 1) AS bmi,
                    prenatal_date AS date_of_service,
                    trimester,
                    birthdate
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id');
        })
            ->selectRaw("
                    name,
                    CASE WHEN bmi < 18.5 THEN
                        'LOW'
                    ELSE
                        NULL
                    END AS bmi_status,
                    birthdate,
                    date_of_service,
                    trimester,
                    TIMESTAMPDIFF(YEAR, birthdate, GROUP_CONCAT(date_of_service)) AS age_year
            ")
            ->whereYear('date_of_service', $request->year)
            ->whereMonth('date_of_service', $request->month)
            ->groupBy('name', 'bmi', 'date_of_service', 'trimester', 'birthdate')
            ->havingRaw('(bmi_status = ? AND trimester = 1) AND (age_year BETWEEN ? AND ?)', [$bmi_status, $age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_high_bmi($request, $bmi_status, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                    CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                    ROUND(patient_weight / POWER((patient_height / 100), 2), 1) AS bmi,
                    prenatal_date AS date_of_service,
                    trimester,
                    birthdate
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id');
        })
            ->selectRaw("
                    name,
                    CASE WHEN bmi >= 23 THEN
                        'HIGH'
                    ELSE
                        NULL
                    END AS bmi_status,
                    birthdate,
                    date_of_service,
                    trimester,
                    TIMESTAMPDIFF(YEAR, birthdate, GROUP_CONCAT(date_of_service)) AS age_year
            ")
            ->whereYear('date_of_service', $request->year)
            ->whereMonth('date_of_service', $request->month)
            ->groupBy('name', 'bmi', 'date_of_service', 'trimester', 'birthdate')
            ->havingRaw('(bmi_status = ? AND trimester = 1) AND (age_year BETWEEN ? AND ?)', [$bmi_status, $age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_2_td_vaccine($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_prenatals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        vaccine_id,
                        birthdate,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1) AS date_of_service,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(status_id ORDER BY status_id DESC), ',', 2), ',', - 1) AS status_id,
                        TIMESTAMPDIFF(YEAR, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)) AS age_year
                    ")
            ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
            ->join('patient_vaccines', 'consult_mc_prenatals.patient_id', '=', 'patient_vaccines.patient_id')
            ->whereVaccineId('TD')
            ->groupBy('consult_mc_prenatals.patient_id', 'vaccine_id')
            ->havingRaw('COUNT(vaccine_id) = 2 AND status_id = 1 AND (age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_3_above_td_vaccine($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_prenatals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        vaccine_id,
                        birthdate,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 3), ',', - 1) AS date_of_service,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(status_id ORDER BY status_id DESC), ',', 3), ',', - 1) AS status_id,
                        TIMESTAMPDIFF(YEAR, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)) AS age_year
                    ")
            ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
            ->join('patient_vaccines', 'consult_mc_prenatals.patient_id', '=', 'patient_vaccines.patient_id')
            ->whereVaccineId('TD')
            ->groupBy('consult_mc_prenatals.patient_id', 'vaccine_id')
            ->havingRaw('COUNT(vaccine_id) = 3 AND status_id = 1 AND (age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_iron_folic($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        service_date AS date_of_service,
                        service_id,
                        service_qty,
                        visit_status,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->whereServiceId('IRON')
            ->where('service_qty', '>=', 180)
            ->whereVisitStatus('Prenatal')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_calcium_carbonate($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        service_date AS date_of_service,
                        service_id,
                        service_qty,
                        visit_status,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->whereServiceId('CALC')
            ->where('service_qty', '>=', 420)
            ->whereVisitStatus('Prenatal')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_iodine_capsule($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        service_date AS date_of_service,
                        service_id,
                        service_qty,
                        visit_status,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->whereServiceId('IODN')
            ->where('service_qty', '>=', 2)
            ->whereVisitStatus('Prenatal')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_deworming_tablet($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        service_date AS date_of_service,
                        service_id,
                        service_qty,
                        visit_status,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->whereServiceId('DWRMG')
            ->where('service_qty', '>=', 1)
            ->whereVisitStatus('Prenatal')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
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
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->when($class == $class,  fn($query) =>
                     $query->whereServiceId($class2)
                           ->whereVisitStatus('Prenatal')
                           ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
                )
            ->when($class == $class, fn($query) =>
                     $query->whereServiceId($class2)
                           ->wherePositiveResult('1')
                           ->whereVisitStatus('Prenatal')
                           ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
                )
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_births($request, $age_year_bracket1, $age_year_bracket2)
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
    }

    public function post_partum_2_checkup($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_postparta')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        postpartum_date AS date_of_service,
                        visit_sequence,
                        TIMESTAMPDIFF(YEAR, birthdate, postpartum_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_postparta.patient_id', '=', 'patients.id')
            ->whereVisitSequence('2')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function post_partum_vitamin_a($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
	                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1) AS date_of_service,
                        service_id,
                        service_qty,
                        visit_status,
                        TIMESTAMPDIFF(YEAR, birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->whereServiceId('VITA')
            ->whereVisitStatus('Postpartum')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$age_year_bracket1, $age_year_bracket2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

}
