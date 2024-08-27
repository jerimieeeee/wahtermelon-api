<?php

namespace App\Services\Childcare;

use Illuminate\Support\Facades\DB;

class ChildCareReportService
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

    public function get_mother_vaccine()
    {
        return DB::table('patient_vaccines')
            ->selectRaw('
                        patient_id
                    ')
            ->whereVaccineId('TD')
            ->groupBy('patient_id')
            ->havingRaw('COUNT(vaccine_id) >= 2');
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

    public function get_vaccines($request, $vaccine_id, $vaccine_seq, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $vaccine_id, $patient_gender, $vaccine_seq) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            patients.birthdate,
                            vaccine_date AS date_of_service,
                            vaccine_id,
                            status_id,
                            (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date) AS vaccine_seq,
                            municipality_code,
                            barangay_code
                ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
                })
                ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                    $q->where('patient_vaccines.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'fac', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'muncity', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'brgys', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->whereStatusId('1')
                ->whereVaccineId($vaccine_id)
                ->where('patients.gender', $patient_gender)
                ->whereBetween(DB::raw('DATE(vaccine_date)'), [$request->start_date, $request->end_date])
//                ->havingRaw('vaccine_seq = ? AND YEAR(date_of_service) = ? AND MONTH(date_of_service) = ?', [$vaccine_seq, $request->year, $request->month]);
                ->havingRaw('vaccine_seq = ?' , [$vaccine_seq]);

        });
    }

    public function get_cpab($request, $patient_gender)
    {
        return DB::table('patient_ccdevs')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    patients.birthdate,
                        patients.birthdate AS date_of_service,
	                    municipality_code,
	                    barangay_code
                    ")
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->join('users', 'patient_ccdevs.user_id', '=', 'users.id')
            ->joinSub($this->get_mother_vaccine(), 'mother_vaccine', function ($join) {
                $join->on('mother_vaccine.patient_id', '=', 'patient_ccdevs.mothers_id');
            })
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_ccdevs.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_ccdevs.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
//            ->whereYear('patients.birthdate', $request->year)
//            ->whereMonth('patients.birthdate', $request->month)
            ->whereBetween(DB::raw('DATE(patients.birthdate)'), [$request->start_date, $request->end_date])
            ->where('patients.gender', $patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_ipv2($request, $patient_gender, $vaccine_seq, $age_year)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            patients.birthdate AS birthdate,
                            vaccine_date AS date_of_service,
                            vaccine_id,
                            status_id,
                            (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date) AS vaccine_seq,
                            TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) AS age_year,
                            municipality_code,
                            barangay_code
                    ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
                })
                ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                    $q->where('patient_vaccines.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'fac', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'muncity', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'brgys', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->whereVaccineId('IPV')
                ->where('patients.gender', $patient_gender)
                ->whereStatusId('1');
        })
            ->selectRaw('
                        name,
                        birthdate,
                        date_of_service,
                        vaccine_seq,
                        age_year,
                        municipality_code,
                        barangay_code
            ')
            ->whereBetween(DB::raw('DATE(date_of_service)'), [$request->start_date, $request->end_date])
            ->havingRaw('(vaccine_seq = ?) AND (age_year = ?)', [$vaccine_seq, $age_year])
            ->orderBy('name', 'ASC');
    }

    public function get_fic_cic($request, $patient_gender, $immunization_status)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        SUM(
                            CASE WHEN vaccine_id = 'BCG' THEN
                                1
                            ELSE
                                0
                            END) AS 'BCG',
                        SUM(
                            CASE WHEN vaccine_id = 'PENTA' THEN
                                1
                            ELSE
                                0
                            END) AS 'PENTA',
                        SUM(
                            CASE WHEN vaccine_id = 'OPV' THEN
                                1
                            ELSE
                                0
                            END) AS 'OPV',
                        SUM(
                            CASE WHEN vaccine_id = 'MCV' THEN
                                1
                            ELSE
                                0
                            END) AS 'MCV',
                        MAX(vaccine_date) AS date_of_service,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(status_id ORDER BY vaccine_date DESC), ',', 1), ',', - 1) AS status_id,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, MAX(vaccine_date)) AS age_month
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_vaccines.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->whereIn('vaccine_id', ['BCG', 'PENTA', 'OPV', 'MCV'])
            ->groupBy('patient_vaccines.patient_id')
            ->when($immunization_status == 'FIC', function ($query) use ($request) {
                $query->havingRaw('BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month < 13 AND status_id = 1 AND date_of_service BETWEEN ? AND ?', [$request->start_date, $request->end_date]);
            })
            ->when($immunization_status == 'CIC', function ($query) use ($request) {
                $query->havingRaw('(BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month BETWEEN 13 AND 23) AND status_id = 1 AND date_of_service BETWEEN ? AND ?', [$request->start_date, $request->end_date]);
            })
            ->when($immunization_status == 'COMPLETED', function ($query) use ($request) {
                $query->havingRaw('BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month >= 24 AND status_id = 1 AND date_of_service BETWEEN ? AND ?', [$request->start_date, $request->end_date]);
            })
            ->orderBy('name', 'ASC');
    }

    public function init_breastfeeding($request, $patient_gender)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    patients.birthdate,
                        breastfed_date AS date_of_service,
                        municipalities_brgy.municipality_code AS municipality_code,
                        municipalities_brgy.barangay_code
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patient_ccdevs', 'patient_mc.patient_id', '=', 'patient_ccdevs.mothers_id')
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_mc.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereBreastfeeding(1)
            ->where('patients.gender', $patient_gender)
//            ->whereYear('breastfed_date', $request->year)
//            ->whereMonth('breastfed_date', $request->month)
            ->whereBetween(DB::raw('DATE(breastfed_date)'), [$request->start_date, $request->end_date])
            ->orderBy('name', 'ASC');
    }

    public function get_lbw_iron($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birth_weight,
                        patients.birthdate AS birthdate,
                        service_date AS date_of_service,
                        service_id,
                        status_id,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) AS age_month,
                        TIMESTAMPDIFF(DAY, DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL TIMESTAMPDIFF(YEAR, patients.birthdate, service_date)
                                    YEAR), INTERVAL TIMESTAMPDIFF(MONTH, DATE_ADD(patients.birthdate, INTERVAL TIMESTAMPDIFF(YEAR, patients.birthdate, service_date)
                                        YEAR), service_date) MONTH), service_date) AS days,
                        municipality_code,
                        barangay_code
                    ")
                ->from('consult_ccdev_services')
                ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
                ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
                ->join('users', 'consult_ccdev_services.user_id', '=', 'users.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
                })
                ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                    $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'fac', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'muncity', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'brgys', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->whereServiceId('IRON')
                ->where('patients.gender', $patient_gender)
                ->whereStatusId('1')
                ->groupBy('patients.id', 'service_id', 'service_date', 'status_id', 'birth_weight', 'municipality_code', 'barangay_code');
        })
            ->selectRaw('
                        name,
                        birth_weight,
                        birthdate,
                        date_of_service,
                        service_id,
                        status_id,
                        age_month,
                        days,
                        municipality_code,
                        barangay_code
            ')
            ->whereBetween(DB::raw('DATE(date_of_service)'), [$request->start_date, $request->end_date])
            ->havingRaw('(birth_weight < 2.5) AND (age_month BETWEEN 1 AND 3 AND days <= 29)')
            ->orderBy('name', 'ASC');
    }

    public function get_vit_a_1st($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate AS birthdate,
                        service_date AS date_of_service,
                        service_id,
                        status_id,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) AS age_month,
                        TIMESTAMPDIFF(DAY, DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL TIMESTAMPDIFF(YEAR, patients.birthdate, service_date)
                                    YEAR), INTERVAL TIMESTAMPDIFF(MONTH, DATE_ADD(patients.birthdate, INTERVAL TIMESTAMPDIFF(YEAR, patients.birthdate, service_date)
                                        YEAR), service_date) MONTH), service_date) AS days,
                        municipality_code,
                        barangay_code
                    ")
                ->from('consult_ccdev_services')
                ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
                ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
                ->join('users', 'consult_ccdev_services.user_id', '=', 'users.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
                })
                ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                    $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'fac', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'muncity', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'brgys', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->whereServiceId('VITA')
                ->where('patients.gender',$patient_gender)
                ->whereStatusId('1')
                ->groupBy('patients.id', 'service_id', 'service_date', 'status_id', 'birth_weight', 'municipality_code', 'barangay_code');
        })
            ->selectRaw('
                        name,
                        birthdate,
                        date_of_service,
                        service_id,
                        status_id,
                        age_month,
                        days,
                        municipality_code,
                        barangay_code
            ')
            ->whereBetween(DB::raw('DATE(date_of_service)'), [$request->start_date, $request->end_date])
            ->havingRaw('(age_month BETWEEN 6 AND 11 AND days <= 29)')
            ->orderBy('name', 'ASC');
    }

    public function get_vit_a_2nd_3rd($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birth_weight,
                        patients.birthdate AS birthdate,
                        service_date AS date_of_service,
                        service_id,
                        status_id,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) AS age_month,
                        TIMESTAMPDIFF(DAY, DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL TIMESTAMPDIFF(YEAR, patients.birthdate, service_date)
                                    YEAR), INTERVAL TIMESTAMPDIFF(MONTH, DATE_ADD(patients.birthdate, INTERVAL TIMESTAMPDIFF(YEAR, patients.birthdate, service_date)
                                        YEAR), service_date) MONTH), service_date) AS days,
                        municipality_code,
                        barangay_code
                    ")
                ->from('consult_ccdev_services')
                ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
                ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
                ->join('users', 'consult_ccdev_services.user_id', '=', 'users.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
                })
                ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                    $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'fac', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'muncity', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'brgys', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->whereIn('service_id', ['VITA2', 'VITA3'])
                ->where('patients.gender', $patient_gender)
                ->whereStatusId('1')
                ->groupBy('patients.id', 'service_id', 'service_date', 'status_id', 'birth_weight', 'municipality_code', 'barangay_code');
        })
            ->selectRaw('
                        name,
                        birthdate,
                        date_of_service,
                        service_id,
                        status_id,
                        age_month,
                        days,
                        municipality_code,
                        barangay_code
            ')
            ->whereServiceId('VITA3')
            ->whereBetween(DB::raw('DATE(date_of_service)'), [$request->start_date, $request->end_date])
            ->havingRaw('(age_month BETWEEN 12 AND 59 AND days <= 29)')

            ->orderBy('name', 'ASC');
    }

    public function get_deworming($request, $patient_gender, $param1, $param2)
    {
        return DB::table('medicine_prescriptions')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(prescription_date ORDER BY prescription_date ASC), ',', 2), ',', - 1) AS date_of_service,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(prescription_date ORDER BY prescription_date ASC), ',', 2), ',', - 1)) AS age,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'medicine_prescriptions.patient_id', '=', 'patients.id')
            ->join('users', 'medicine_prescriptions.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'medicine_prescriptions.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('medicine_prescriptions.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereIn('konsulta_medicine_code', ['ALBED0000000006SUS1400195BOTTL', 'ALBED0000000006SUS1400231BOTTL', 'ALBED0000000006SUS1400379BOTTL', 'ALBED0000000006SUS1400469BOTTL', 'ALBED0000000034TAB490000000000'])
            ->where('patients.gender',$patient_gender)
            ->groupBy('medicine_prescriptions.patient_id', 'municipality_code', 'barangay_code')
            ->havingRaw('(age BETWEEN ? AND ?) AND (COUNT(medicine_prescriptions.patient_id) >= 2) AND DATE(date_of_service) BETWEEN ? AND ?', [$param1, $param2, $request->start_date, $request->end_date])
            ->orderBy('name', 'ASC');
    }

    public function get_sick_infant_children($request, $patient_gender, $param1, $param2)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
           	            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('users', 'consult_notes_final_dxes.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_notes.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code)
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'])
            ->where('patients.gender',$patient_gender)
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->havingRaw('(age_month BETWEEN ? AND ?) ', [$param1, $param2])
            ->orderBy('name', 'ASC');
    }

    public function get_diarrhea_pneumonia($request, $disease, $patient_gender)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
           	            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('users', 'consult_notes_final_dxes.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_notes.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender',$patient_gender)
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->when($disease == 'DIARRHEA', fn ($query) => $query->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3'])
                ->havingRaw('(age_month BETWEEN 0 AND 59)'))
            ->when($disease == 'PNEUMONIA', fn ($query) => $query->whereIn('icd10_code', ['B05.2', 'J10', 'J11', 'J17.1', 'J10.0', 'J10.1', 'J10.8'])
                ->havingRaw('(age_month BETWEEN 0 AND 59)'))
            ->orderBy('name', 'ASC');
    }

    public function get_mnp($request, $service, $patient_gender)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        service_id,
           	            service_date AS date_of_service,
           	            quantity,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ccdev_services.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(service_date)'), [$request->start_date, $request->end_date])
            ->whereStatusId('1')
            ->when($service == 'MNP', fn ($query) => $query->whereServiceId('MNP')
                ->havingRaw('(age_month BETWEEN 6 AND 11) AND (quantity >= 90)'))
            ->when($service == 'MNP2', fn ($query) => $query->whereServiceId('MNP2')
                ->havingRaw('(age_month BETWEEN 12 AND 23) AND (quantity >= 180)'))
            ->groupBy('consult_ccdev_services.patient_id', 'service_id', 'service_date', 'quantity', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_sick_infant_children_with_vit_a($request, $patient_gender, $age_month)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        prescription_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->join('users', 'consult_notes_final_dxes.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_notes.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(prescription_date)'), [$request->start_date, $request->end_date])
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'])
            ->when($age_month == 6, fn ($query) => $query->whereIn('konsulta_medicine_code', ['RETA10000001103CAP310000000000'])
                ->havingRaw('(age_month BETWEEN 6 AND 11)')
            )
            ->when($age_month == 12, fn ($query) => $query->whereIn('konsulta_medicine_code', ['VITAA0000000294CAP310000000000', 'RETA10000000294CAP310000000000'])
                ->havingRaw('(age_month BETWEEN 12 AND 59)')
            )
            ->groupBy('patients.id', 'age_month', 'prescription_date', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_diarrhea_ors_and_ors_with_zinc($request, $patient_gender, $medicine)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        prescription_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->join('users', 'consult_notes_final_dxes.user_id', '=', 'users.id')
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3'])
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_notes.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(prescription_date)'), [$request->start_date, $request->end_date])
            ->when($medicine == 'ORS', fn ($query) => $query->whereIn('konsulta_medicine_code', ['ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01', 'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01', 'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'])
                ->havingRaw('(age_month BETWEEN 0 AND 59)')
            )
            ->when($medicine == 'ORS WITH ZINC', fn ($query) => $query->whereIn('konsulta_medicine_code', ['ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01', 'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01', 'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'])
                ->whereIn('konsulta_medicine_code', ['ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL', 'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'])
                ->havingRaw('(age_month BETWEEN 0 AND 59)')
            )
            ->orderBy('name', 'ASC');
    }

    public function get_ebf($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) AS date_of_service,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ccdev_breastfeds.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_breastfeds.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_ccdev_breastfeds.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->where(fn ($query) => $query->where([
                ['bfed_month1', '=', '1'],
                ['bfed_month2', '=', '1'],
                ['bfed_month3', '=', '1'],
                ['bfed_month4', '=', '1'],
            ])
            )
            ->havingRaw('date_of_service BETWEEN ? AND ?', [$request->start_date, $request->end_date])
            ->orderBy('name', 'ASC');
    }

    public function get_pneumonia_with_treatment($request, $patient_gender, $disease)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        prescription_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->join('users', 'consult_notes_final_dxes.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender',$patient_gender)
            ->whereIn('icd10_code', ['B05.2', 'J10', 'J11', 'J17.1', 'J10.0', 'J10.1', 'J10.8'])
            ->whereBetween(DB::raw('DATE(prescription_date)'), [$request->start_date, $request->end_date])
            ->when($disease == 'PNEUMONIA', fn ($query) => $query->whereIn('konsulta_medicine_code', ['AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000', 'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01', 'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'])
                ->havingRaw('(age_month BETWEEN 0 AND 59)')
            )
            ->orderBy('name', 'ASC');
    }

    public function get_overweight_obese($request, $patient_gender, $class)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vitals_date ORDER BY vitals_date DESC), ',', 1), ',', - 1), '%Y-%m-%d') AS date_of_service,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(patient_weight_for_age ORDER BY vitals_date DESC), ',', 1), ',', - 1) AS weight_for_age,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(patient_age_months ORDER BY vitals_date DESC), ',', 1), ',', - 1) AS patient_age_months,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vitals.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_vitals.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_vitals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->when($class == 'Obese', fn ($query) => $query->whereIn('patient_weight_for_age', ['Obese', 'Overweight'])
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND date_of_service BETWEEN ? AND ?', [$request->start_date, $request->end_date])
            )
            ->when($class == 'Normal', fn ($query) => $query->whereIn('patient_weight_for_age', ['Normal'])
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND date_of_service BETWEEN ? AND ?', [$request->start_date, $request->end_date])
            )
            ->groupBy('patient_vitals.patient_id', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_complimentary_feeding($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        comp_fed_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ccdev_breastfeds.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_breastfeds.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_ccdev_breastfeds.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(comp_fed_date)'), [$request->start_date, $request->end_date])
            ->where(fn ($query) => $query->where([
                ['bfed_month1', '=', '1'],
                ['bfed_month2', '=', '1'],
                ['bfed_month3', '=', '1'],
                ['bfed_month4', '=', '1'],
            ])
            ->whereNotNull('comp_fed_date')
            )
            ->havingRaw('(age_month BETWEEN 6 AND 11)')
            ->orderBy('name', 'ASC');
    }

    public function get_complimentary_feeding_stop_bfed($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        comp_fed_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ccdev_breastfeds.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_breastfeds.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_ccdev_breastfeds.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereBetween(DB::raw('DATE(comp_fed_date)'), [$request->start_date, $request->end_date])
            ->whereNull('ebf_date')
            ->whereNotNull('comp_fed_date')
            ->havingRaw('(age_month >= 6)')
            ->where('patients.gender', $patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_stunted_wasted($request, $patient_gender, $class)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        DATE_FORMAT(vitals_date, '%Y-%m-%d') AS date_of_service,
                        patient_age_months,
                        patient_height_for_age AS height_for_age,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vitals.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_vitals.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_vitals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->where('patients.gender', $patient_gender)
            ->whereBetween(DB::raw('DATE(vitals_date)'), [$request->start_date, $request->end_date])
            ->when($class == 'Stunted', fn ($query) => $query->whereIn('patient_height_for_age', ['Stunted'])
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59)')
            )
            ->when($class == 'Wasted', fn ($query) => $query->wherePatientHeightForAge($class)
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59)')
            )
            ->orderBy('name', 'ASC');
    }
}
