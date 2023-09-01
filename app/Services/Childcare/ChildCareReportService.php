<?php

namespace App\Services\Childcare;

use Illuminate\Support\Facades\DB;

class ChildCareReportService
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
                        municipalities.code AS municipality_code,
                        barangays.code AS barangay_code
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.code', 'barangays.code');
    }

    public function get_vaccines($request, $vaccine_id, $vaccine_seq, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $vaccine_id, $patient_gender, $vaccine_seq) {
            $query->selectRaw("
                    CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                    birthdate,
                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date DESC), ',', 1), ',', - 1) AS date_of_service,
                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_id ORDER BY vaccine_date DESC), ',', 1), ',', - 1) AS vaccine_id,
                    municipality_code,
                    barangay_code
                ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('patient_vaccines.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })
                ->whereStatusId('1')
                ->whereVaccineId($vaccine_id)
                ->whereGender($patient_gender)
                ->groupBy('patient_vaccines.patient_id')
                ->havingRaw('COUNT(patient_vaccines.id) = ? AND YEAR(date_of_service) = ? AND MONTH(date_of_service) = ?', [$vaccine_seq, $request->year, $request->month]);
        });
    }

    public function get_cpab($request, $patient_gender)
    {
        return DB::table('patient_ccdevs')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    birthdate,
	                    birthdate AS date_of_service,
	                    municipality_code,
	                    barangay_code
                    ")
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->joinSub($this->get_mother_vaccine(), 'mother_vaccine', function ($join) {
                $join->on('mother_vaccine.patient_id', '=', 'patient_ccdevs.mothers_id');
            })
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_ccdevs.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_ccdevs.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->whereYear('birthdate', $request->year)
            ->whereMonth('birthdate', $request->month)
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_ipv2($request, $patient_gender, $vaccine_seq, $age_year)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
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
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('patient_vaccines.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
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

    public function get_fic_cic($request, $patient_gender, $immunization_status)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                            patient_vaccines.patient_id,
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            gender,
                            birthdate,
                            vaccine_date,
                            vaccine_id,
                            status_id,
                            municipality_code,
                            barangay_code,
                            patient_vaccines.facility_code AS facility_code
                ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_vaccines.patient_id');
                })
                ->whereIn('vaccine_id', ['BCG', 'PENTA', 'OPV', 'MCV'])
                ->groupBy('patient_vaccines.patient_id', 'vaccine_date', 'vaccine_id', 'status_id', 'municipality_code', 'barangay_code');
        })
            ->selectRaw("
                name,
                gender,
                birthdate,
                MAX(vaccine_date) AS date_of_service,
                TIMESTAMPDIFF(MONTH, birthdate, MAX(vaccine_date)) AS age_month,
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
                SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(status_id ORDER BY status_id DESC), ',', 1), ',', - 1) AS status_id,
                municipality_code,
                barangay_code
        ")
            ->where('status_id', '=', '1')
            ->groupBy('birthdate', 'municipality_code', 'barangay_code', 'name', 'gender')
            ->when($request->category == 'all', function ($q) {
                $q->where('facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->when($immunization_status == 'FIC', function ($query) use ($patient_gender, $request) {
                $query->whereGender($patient_gender)
                    ->havingRaw('BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month <= 12 AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month]);
            })
            ->when($immunization_status == 'CIC', function ($query) use ($patient_gender, $request) {
                $query->whereGender($patient_gender)
                    ->havingRaw('(BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month BETWEEN 13 AND 23) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month]);
            })
            ->when($immunization_status == 'COMPLETED', fn ($query) => $query->whereGender($patient_gender)
                ->havingRaw('(BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month >= 24) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            );
    }

    public function init_breastfeeding($request, $patient_gender)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    birthdate,
                        breastfed_date AS date_of_service,
                        municipalities_brgy.municipality_code AS municipality_code,
                        municipalities_brgy.barangay_code
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_mc.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_mc_post_registrations.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereBreastfeeding(1)
            ->whereGender($patient_gender)
            ->whereYear('breastfed_date', $request->year)
            ->whereMonth('breastfed_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_lbw_iron($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birth_weight,
                        birthdate,
                        service_date AS date_of_service,
                        service_id,
                        status_id,
                        TIMESTAMPDIFF(MONTH, birthdate, service_date) AS age_month,
                        TIMESTAMPDIFF(DAY, DATE_ADD(DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, service_date)
                                    YEAR), INTERVAL TIMESTAMPDIFF(MONTH, DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, service_date)
                                        YEAR), service_date) MONTH), service_date) AS days,
                        municipality_code,
                        barangay_code
                    ")
                ->from('consult_ccdev_services')
                ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
                ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->code));
                })
                ->whereServiceId('IRON')
                ->whereGender($patient_gender)
                ->whereStatusId('1')
                ->groupBy('patients.id', 'service_id', 'service_date', 'status_id', 'birth_weight', 'municipality_code', 'barangay_code');
        })
            ->selectRaw('
                        name,
                        gender,
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
            ->havingRaw('(birth_weight < 2.5) AND (age_month BETWEEN 1 AND 3 AND days <= 29) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_vit_a_1st($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        service_date AS date_of_service,
                        service_id,
                        status_id,
                        TIMESTAMPDIFF(MONTH, birthdate, service_date) AS age_month,
                        TIMESTAMPDIFF(DAY, DATE_ADD(DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, service_date)
                                    YEAR), INTERVAL TIMESTAMPDIFF(MONTH, DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, service_date)
                                        YEAR), service_date) MONTH), service_date) AS days,
                        municipality_code,
                        barangay_code
                    ")
                ->from('consult_ccdev_services')
                ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
                ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->code));
                })
                ->whereServiceId('VITA')
                ->whereGender($patient_gender)
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
            ->havingRaw('(age_month BETWEEN 6 AND 11 AND days <= 29) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_vit_a_2nd_3rd($request, $patient_gender)
    {
        return DB::table(function ($query) use ($request, $patient_gender) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birth_weight,
                        birthdate,
                        service_date AS date_of_service,
                        service_id,
                        status_id,
                        TIMESTAMPDIFF(MONTH, birthdate, service_date) AS age_month,
                        TIMESTAMPDIFF(DAY, DATE_ADD(DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, service_date)
                                    YEAR), INTERVAL TIMESTAMPDIFF(MONTH, DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, service_date)
                                        YEAR), service_date) MONTH), service_date) AS days,
                        municipality_code,
                        barangay_code
                    ")
                ->from('consult_ccdev_services')
                ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
                ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
                })
                ->when($request->category == 'facility', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'municipality', function ($q) use ($request) {
                    $q->whereIn('municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'barangay', function ($q) use ($request) {
                    $q->whereIn('barangay_code', explode(',', $request->code));
                })
                ->whereIn('service_id', ['VITA2', 'VITA3'])
                ->whereGender($patient_gender)
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
            ->havingRaw('(age_month BETWEEN 12 AND 59 AND days <= 29) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_deworming($request, $patient_gender, $param1, $param2)
    {
        return DB::table('medicine_prescriptions')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        prescription_date AS date_of_service,
                        TIMESTAMPDIFF(YEAR, birthdate, prescription_date) as age_year,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'medicine_prescriptions.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'medicine_prescriptions.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('medicine_prescriptions.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->whereIn('konsulta_medicine_code', ['ALBED0000000006SUS1400195BOTTL', 'ALBED0000000006SUS1400231BOTTL', 'ALBED0000000006SUS1400379BOTTL', 'ALBED0000000006SUS1400469BOTTL', 'ALBED0000000034TAB490000000000'])
            ->whereGender($patient_gender)
            ->groupBy('medicine_prescriptions.patient_id', 'prescription_date', 'municipality_code', 'barangay_code')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND (COUNT(medicine_prescriptions.patient_id) >= 2) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$param1, $param2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_sick_infant_children($request, $patient_gender, $param1, $param2)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
           	            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'])
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'consult_date', 'municipality_code', 'barangay_code')
            ->havingRaw('(age_month BETWEEN ? AND ?) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$param1, $param2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_diarrhea_pneumonia($request, $disease, $patient_gender)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
           	            DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->when($disease == 'DIARRHEA', fn ($query) => $query->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3'])
                ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month]))
            ->when($disease == 'PNEUMONIA', fn ($query) => $query->whereIn('icd10_code', ['B05.2', 'J10', 'J11', 'J17.1', 'J10.0', 'J10.1', 'J10.8'])
                ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month]))
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'consult_date', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_mnp($request, $service, $patient_gender)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        service_id,
           	            service_date AS date_of_service,
           	            quantity,
                        TIMESTAMPDIFF(MONTH, birthdate, service_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->when($service == 'MNP', fn ($query) => $query->whereServiceId('MNP')
                ->havingRaw('(age_month BETWEEN 6 AND 11) AND (quantity >= 90) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month]))
            ->when($service == 'MNP2', fn ($query) => $query->whereServiceId('MNP2')
                ->havingRaw('(age_month BETWEEN 12 AND 23) AND (quantity >= 180) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month]))
            ->whereGender($patient_gender)
            ->whereStatusId('1')
            ->groupBy('consult_ccdev_services.patient_id', 'service_id', 'service_date', 'quantity', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_sick_infant_children_with_vit_a($request, $patient_gender, $age_month)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        prescription_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('medicine_prescriptions.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'])
            ->when($age_month == 6, fn ($query) => $query->whereKonsultaMedicineCode('RETA10000001103CAP310000000000')
                ->havingRaw('(age_month BETWEEN 6 AND 11) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($age_month == 12, fn ($query) => $query->whereKonsultaMedicineCode('VITAA0000000294CAP310000000000')
                ->havingRaw('(age_month BETWEEN 12 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'prescription_date', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_diarrhea_ors_and_ors_with_zinc($request, $patient_gender, $medicine)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        prescription_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1', 'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3'])
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('medicine_prescriptions.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->when($medicine == 'ORS', fn ($query) => $query->whereIn('konsulta_medicine_code', ['ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01', 'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01', 'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'])
                ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($medicine == 'ORS WITH ZINC', fn ($query) => $query->whereIn('konsulta_medicine_code', ['ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01', 'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01', 'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'])
                ->whereIn('konsulta_medicine_code', ['ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL', 'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'])
                ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'prescription_date', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_ebf($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        DATE_ADD(DATE_ADD(birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) AS date_of_service,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_breastfeds.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('consult_ccdev_breastfeds.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->where(fn ($query) => $query->where([
                ['bfed_month1', '=', '1'],
                ['bfed_month2', '=', '1'],
                ['bfed_month3', '=', '1'],
                ['bfed_month4', '=', '1'],
            ])
            )
            ->havingRaw('DATE_ADD(DATE_ADD(birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_pneumonia_with_treatment($request, $patient_gender, $disease)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        prescription_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('medicine_prescriptions.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->whereIn('icd10_code', ['B05.2', 'J10', 'J11', 'J17.1', 'J10.0', 'J10.1', 'J10.8'])
            ->when($disease == 'PNEUMONIA', fn ($query) => $query->whereIn('konsulta_medicine_code', ['AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000', 'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01', 'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'])
                ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'prescription_date', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_overweight_obese($request, $patient_gender, $class)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        gender,
                        DATE_FORMAT(SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vitals_date ORDER BY vitals_date DESC), ',', 1), ',', - 1), '%Y-%m-%d') AS date_of_service,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(patient_weight_for_age ORDER BY vitals_date DESC), ',', 1), ',', - 1) AS weight_for_age,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(patient_age_months ORDER BY vitals_date DESC), ',', 1), ',', - 1) AS patient_age_months,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_vitals.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_vitals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->when($class == 'Obese', fn ($query) => $query->whereIn('patient_weight_for_age', ['Obese', 'Overweight'])
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($class == 'Normal', fn ($query) => $query->whereIn('patient_weight_for_age', ['Normal'])
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->whereGender($patient_gender)
            ->groupBy('patient_vitals.patient_id', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_complimentary_feeding($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        comp_fed_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, birthdate, comp_fed_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_breastfeds.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('consult_ccdev_breastfeds.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->where(fn ($query) => $query->where([
                ['bfed_month1', '=', '1'],
                ['bfed_month2', '=', '1'],
                ['bfed_month3', '=', '1'],
                ['bfed_month4', '=', '1'],
            ])
                ->whereNotNull('comp_fed_date')
            )
            ->havingRaw('(age_month BETWEEN 6 AND 11) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_complimentary_feeding_stop_bfed($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        comp_fed_date AS date_of_service,
                        TIMESTAMPDIFF(MONTH, birthdate, comp_fed_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_breastfeds.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('consult_ccdev_breastfeds.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->whereNull('ebf_date')
            ->whereNotNull('comp_fed_date')
            ->havingRaw('(age_month >= 6) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_stunted_wasted($request, $patient_gender, $class)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        DATE_FORMAT(vitals_date, '%Y-%m-%d') AS date_of_service,
                        patient_age_months,
                        patient_height_for_age AS height_for_age,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_vitals.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_vitals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangay_code', explode(',', $request->code));
            })
            ->when($class == 'Stunted', fn ($query) => $query->whereIn('patient_height_for_age', ['Stunted'])
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->when($class == 'Wasted', fn ($query) => $query->wherePatientHeightForAge($class)
                ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND year(date_of_service) = ? AND month(date_of_service) = ?', [$request->year, $request->month])
            )
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }
}
