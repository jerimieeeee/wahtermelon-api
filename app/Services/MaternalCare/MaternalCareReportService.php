<?php

namespace App\Services\MaternalCare;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class MaternalCareReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
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
    }

    public function get_4prenatal_give_birth($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request) {
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
                      patients.birthdate AS birthdate,
                      DATE_FORMAT(GROUP_CONCAT(DISTINCT delivery_date), '%Y-%m-%d') AS date_of_service,
                      TIMESTAMPDIFF(YEAR, patients.birthdate, GROUP_CONCAT(DISTINCT delivery_date)) AS age_year,
                      municipalities_brgy.municipality_code AS municipality_code,
                      municipalities_brgy.barangay_code AS barangay_code,
                      consult_mc_prenatals.facility_code AS facility_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->join('patient_mc', 'patients.id', '=', 'patient_mc.patient_id')
                ->join('patient_mc_post_registrations', 'patient_mc.id', '=', 'patient_mc_post_registrations.patient_mc_id')
                ->join('users', 'consult_mc_prenatals.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_mc_prenatals.facility_code', 'consult_mc_prenatals.patient_id');
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
            ->whereBetween(DB::raw('DATE(date_of_service)'), [$request->start_date, $request->end_date])
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
                            patients.birthdate AS birthdate,
                            municipality_code,
                            barangay_code,
                            consult_mc_prenatals.facility_code AS facility_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->join('users', 'consult_mc_prenatals.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_mc_prenatals.facility_code', 'consult_mc_prenatals.patient_id');
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
            ->groupBy('name', 'bmi', 'birthdate', 'trimester', 'municipality_code', 'barangay_code')
            ->when($bmi_status == 'NORMAL', function ($query) use ($age_year_bracket1, $age_year_bracket2, $request) {
                $query->havingRaw("(bmi_status = 'NORMAL' AND trimester = 1) AND (age_year BETWEEN ? AND ?) AND (date_of_service BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2, $request->start_date, $request->end_date]);
            })
            ->when($bmi_status == 'HIGH', function ($query) use ($age_year_bracket1, $age_year_bracket2, $request) {
                $query->havingRaw("(bmi_status = 'HIGH' AND trimester = 1) AND (age_year BETWEEN ? AND ?) AND (date_of_service BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2, $request->start_date, $request->end_date]);
            })
            ->when($bmi_status == 'LOW', function ($query) use ($age_year_bracket1, $age_year_bracket2, $request) {
                $query->havingRaw("(bmi_status = 'LOW' AND trimester = 1) AND (age_year BETWEEN ? AND ?) AND (date_of_service BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2, $request->start_date, $request->end_date]);
            })
            ->havingRaw("DATE(date_of_service) BETWEEN ? AND ?", [$request->start_date, $request->end_date]);
    }

    public function pregnant_assessed_bmi($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            ROUND(patient_weight / POWER((patient_height / 100), 2), 1) AS bmi,
                            prenatal_date AS date_of_service,
                            trimester,
                            patients.birthdate AS birthdate,
                            municipality_code,
                            barangay_code,
                            consult_mc_prenatals.facility_code AS facility_code
                ")
                ->from('consult_mc_prenatals')
                ->join('patients', 'consult_mc_prenatals.patient_id', '=', 'patients.id')
                ->join('users', 'consult_mc_prenatals.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_mc_prenatals.facility_code', 'consult_mc_prenatals.patient_id');
                });
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
            ->whereBetween(DB::raw('DATE(date_of_service)'), [$request->start_date, $request->end_date])
            ->groupBy('name', 'bmi', 'birthdate', 'trimester', 'municipality_code', 'barangay_code')
            ->havingRaw("(bmi_status IN ('HIGH', 'NORMAL', 'LOW') AND trimester = 1) AND (age_year BETWEEN ? AND ?)", [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function pregnant_td2_vaccine($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request, $age_year_bracket1, $age_year_bracket2) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            patients.birthdate,
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
                ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vaccines.facility_code', 'patient_vaccines.patient_id');
                })
                ->whereInitialGravidity(1)
                ->whereVaccineId('TD')
                ->whereStatusId('1')
                ->whereBetween(DB::raw('DATE(vaccine_date)'), [$request->start_date, $request->end_date])
                ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2])
                ->havingRaw('vaccine_seq = 2')
                ->orderBy('name', 'ASC');
        });
    }

    public function pregnant_td3_vaccine($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request, $age_year_bracket1, $age_year_bracket2) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            patients.birthdate,
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
                ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    // the last argument is for query if the user is not for provincial report
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vaccines.facility_code', 'patient_vaccines.patient_id');
                })
                ->where('initial_gravidity', '>=', 2)
                ->whereVaccineId('TD')
                ->whereStatusId('1')
                ->whereBetween(DB::raw('DATE(vaccine_date)'), [$request->start_date, $request->end_date])
                ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2])
                ->havingRaw('vaccine_seq IN (3,4,5)')
                ->orderBy('name', 'ASC');
        });
    }

    public function get_service($request, $service, $visit)
    {
        return DB::table(function ($query) use ($request, $service, $visit) {
            $query->selectRaw("
                        patient_mc_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        service_id,
                        GROUP_CONCAT(DATE_FORMAT(service_date, '%Y-%m-%d') ORDER BY service_date ASC) AS service_dates,
                        GROUP_CONCAT(service_qty ORDER BY service_date ASC) AS service_qty,
                        GROUP_CONCAT(TIMESTAMPDIFF(YEAR, patients.birthdate, DATE_FORMAT(service_date, '%Y-%m-%d')) ORDER BY service_date ASC) AS age_year
		            ")
                ->from('consult_mc_services')
                ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
                ->join('users', 'consult_mc_services.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    // the last argument is for query if the user is not for provincial report
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_mc_services.facility_code', 'consult_mc_services.patient_id');
                })
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
                        patients.birthdate,
                        service_date AS date_of_service,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, service_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_services.patient_id', '=', 'patients.id')
            ->join('users', 'consult_mc_services.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                // the last argument is for query if the user is not for provincial report
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_mc_services.facility_code', 'consult_mc_services.patient_id');
            })
            ->whereBetween(DB::raw('DATE(service_date)'), [$request->start_date, $request->end_date])
            ->when($is_positive == 'N', fn ($query) => $query->whereServiceId($service)
                ->whereVisitStatus('Prenatal')
                ->havingRaw('(age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            )
            ->when($is_positive == 'Y', fn ($query) => $query->whereServiceId($service)
                ->wherePositiveResult('1')
                ->whereVisitStatus('Prenatal')
                ->havingRaw('(age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            )
            ->orderBy('name', 'ASC');
    }

    public function post_partum_2_checkup($request, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table('consult_mc_postparta')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        postpartum_date AS date_of_service,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, postpartum_date) AS age_year
                    ")
            ->join('patients', 'consult_mc_postparta.patient_id', '=', 'patients.id')
            ->join('users', 'consult_mc_postparta.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_mc_postparta.facility_code', 'consult_mc_postparta.patient_id');
            })
            ->whereVisitSequence(2)
            ->whereBetween(DB::raw('DATE(postpartum_date)'), [$request->start_date, $request->end_date])
            ->havingRaw('(age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
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
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_mc_post_registrations.facility_code', 'patient_mc.patient_id');
            })
            ->whereIn('outcome_code', ['FDU', 'FDUF', 'LSCSF', 'LSCSM', 'NSDF', 'NSDM', 'SB', 'SBF', 'TWIN'])
            ->whereBetween(DB::raw('DATE(delivery_date)'), [$request->start_date, $request->end_date])
            ->groupBy('patient_mc.patient_id', 'delivery_date', 'outcome_code')
            ->havingRaw('(age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
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
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->when($gender == 'ALL', fn ($query) => $query->whereIn('outcome_code', ['LSCSM', 'NSDM', 'LSCSF', 'NSDF'])
            )
            ->when($gender == 'MALE', fn ($query) => $query->whereIn('outcome_code', ['LSCSM', 'NSDM'])
            )
            ->when($gender == 'FEMALE', fn ($query) => $query->whereIn('outcome_code', ['LSCSF', 'NSDF'])
            )
            ->whereBetween(DB::raw('DATE(delivery_date)'), [$request->start_date, $request->end_date])
            ->groupBy('patient_id', 'delivery_date', 'outcome_code', 'barangays.psgc_10_digit_code', 'patient_mc_post_registrations.barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_livebirths_by_weight($request, $weight)
    {
        return DB::table('patient_ccdevs')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        patients.birthdate AS date_of_service,
                        patient_ccdevs.birth_weight AS birth_weight
                    ")
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->join('patient_mc', 'patient_ccdevs.mothers_id', '=', 'patient_mc.patient_id')
            ->join('patient_mc_post_registrations', 'patient_mc.id', '=', 'patient_mc_post_registrations.patient_mc_id')
            ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('users', 'patient_ccdevs.user_id', '=', 'users.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_ccdevs.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->when($weight == 'NORMAL', fn ($query) => $query->where('patient_ccdevs.birth_weight', '>=', 2.5))
            ->when($weight == 'LOW', fn ($query) => $query->where('patient_ccdevs.birth_weight', '<', 2.5))
            ->when($weight == 'UNKNOWN', fn ($query) => $query->where('patient_ccdevs.birth_weight', 0))
            ->whereBetween(DB::raw('DATE( patients.birthdate)'), [$request->start_date, $request->end_date])
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
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->when($attendant == 'ALL', fn ($query) => $query->whereIn('attendant_code', ['MD', 'MW', 'RN']))
            ->when($attendant == 'DOCTOR', fn ($query) => $query->whereAttendantCode('MD'))
            ->when($attendant == 'NURSE', fn ($query) => $query->whereAttendantCode('RN'))
            ->when($attendant == 'MIDWIFE', fn ($query) => $query->whereAttendantCode('MW'))
            ->whereBetween(DB::raw('DATE(delivery_date)'), [$request->start_date, $request->end_date])
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
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->when($facility == 'ALL', fn ($query) => $query->whereIn('delivery_location_code', ['BHS', 'DOHAM', 'HC', 'HOSP', 'HOSPP', 'LYIN', 'LYINP'])
            )
            ->when($facility == 'PUBLIC-HF', fn ($query) => $query->whereIn('delivery_location_code', ['BHS', 'HC', 'HOSP', 'LYINP', 'DOHAM']))
            ->when($facility == 'PRIVATE-HF', fn ($query) => $query->whereIn('delivery_location_code', ['HOSPP', 'LYIN']))
            ->when($facility == 'NON-HF', fn ($query) => $query->whereIn('delivery_location_code', ['OTHERS', 'HOME']))
            ->whereBetween(DB::raw('DATE(delivery_date)'), [$request->start_date, $request->end_date])
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
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->when($delivery == 'ALL', fn ($query) => $query->whereIn('outcome_code', ['LSCSF', 'LSCSM', 'NSDF', 'NSDM']))
            ->whereBetween(DB::raw('DATE(delivery_date)'), [$request->start_date, $request->end_date])
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
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->where('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('patient_mc_post_registrations.barangay_code', explode(',', $request->code));
            })
            ->whereBetween(DB::raw('DATE(delivery_date)'), [$request->start_date, $request->end_date])
            ->when($delivery == 'NSD', fn ($query) => $query->whereIn('outcome_code', ['NSDF', 'NSDM'])
            )
            ->when($delivery == 'CS', fn ($query) => $query->whereIn('outcome_code', ['LSCSF', 'LSCSM'])
            )
            ->groupBy('patient_id')
            ->havingRaw('(age_year BETWEEN ? AND ?)', [$age_year_bracket1, $age_year_bracket2])
            ->orderBy('name', 'ASC');
    }

    public function get_no_of_pregnancy_outcome_all($request)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                    CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                    patients.birthdate AS birthdate,
                    lmp_date,
                    DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                    TIMESTAMPDIFF(YEAR, patients.birthdate, delivery_date) AS age_year,
                    CASE
                        WHEN FLOOR((DATEDIFF(delivery_date, lmp_date)) / 7) >= 37 THEN 'full_term'
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
                ->join('patient_mc_pre_registrations', 'patient_mc.id', '=', 'patient_mc_pre_registrations.patient_mc_id')
                ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
                ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_mc_post_registrations.facility_code', 'patient_mc.patient_id');
                })
                ->groupBy('status', 'date_of_service', 'patient_mc_post_registrations.delivery_date', 'birthdate', 'name', 'lmp_date', 'outcome_code', 'pregnancy_termination_date', 'pregnancy_termination_code');
        })
        ->selectRaw('
                    *
        ')
        ->where(function($query) {
            $query->whereIn('status', ['full_term', 'pre_term'])
                ->orWhereIn('pregnancy_termination_code', ['SPON', 'IND'])
                ->orWhereIn('outcome_code', ['FDU', 'FDUF', 'SB', 'SBF']);
        })
        ->havingRaw('date_of_service BETWEEN ? AND ? OR pregnancy_termination_date BETWEEN ? AND ? ', [$request->start_date, $request->end_date, $request->start_date, $request->end_date])
        ->orderBy('name', 'ASC');
    }

    public function get_no_of_pregnancy_outcome($request, $status, $age_year_bracket1, $age_year_bracket2)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                    CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                    patients.birthdate AS birthdate,
                    lmp_date,
                    DATE_FORMAT(delivery_date, '%Y-%m-%d') AS date_of_service,
                    TIMESTAMPDIFF(YEAR, patients.birthdate, delivery_date) AS age_year,
                    CASE
                        WHEN FLOOR((DATEDIFF(delivery_date, lmp_date)) / 7) >= 37 THEN 'full_term'
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
                ->join('patient_mc_pre_registrations', 'patient_mc.id', '=', 'patient_mc_pre_registrations.patient_mc_id')
                ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
                ->join('barangays', 'patient_mc_post_registrations.barangay_code', '=', 'barangays.psgc_10_digit_code')
                ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
                ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_mc_post_registrations.facility_code', 'patient_mc.patient_id');
            })
                ->groupBy('status', 'date_of_service', 'patient_mc_post_registrations.delivery_date', 'birthdate', 'name', 'lmp_date', 'outcome_code', 'pregnancy_termination_date', 'pregnancy_termination_code');
            })
            ->selectRaw('
                        *
            ')
            ->when($status == 'FETAL-DEATH', fn ($query) => $query->whereIn('outcome_code', ['FDU', 'FDUF', 'SB', 'SBF'])
                ->havingRaw('(age_year BETWEEN ? AND ?) AND date_of_service BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2, $request->start_date, $request->end_date])
            )
            ->when($status == 'ABORTION', fn ($query) => $query->whereIn('pregnancy_termination_code', ['SPON', 'IND'])
                ->havingRaw('(age_year BETWEEN ? AND ?) AND pregnancy_termination_date BETWEEN ? AND ?', [$age_year_bracket1, $age_year_bracket2, $request->start_date, $request->end_date])
            )
            ->when($status == 'FULL-TERM', fn ($query) => $query->havingRaw('status = ? AND (age_year BETWEEN ? AND ?) AND date_of_service BETWEEN ? AND ?', ['full_term', $age_year_bracket1, $age_year_bracket2, $request->start_date, $request->end_date])
            )
            ->when($status == 'PRE-TERM', fn ($query) => $query->havingRaw('status = ? AND (age_year BETWEEN ? AND ?) AND pregnancy_termination_date BETWEEN ? AND ?', ['pre_term', $age_year_bracket1, $age_year_bracket2, $request->start_date, $request->end_date])
            )
//            ->groupBy('birthdate', 'status', 'name', 'lmp_date', 'date_of_service', 'outcome_code', 'pregnancy_termination_date', 'pregnancy_termination_code')
            ->orderBy('name', 'ASC');
    }
}
