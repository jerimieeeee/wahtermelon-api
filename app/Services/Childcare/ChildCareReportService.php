<?php

namespace App\Services\Childcare;

use Illuminate\Support\Facades\DB;

class ChildCareReportService
{
    public function get_vaccines($request, $vaccine_id, $vaccine_seq, $patient_gender)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',',?), ',', - 1) AS vax_date
                    ", [$vaccine_seq])
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->whereVaccineId($vaccine_id)
            ->whereStatusId('1')
            ->whereGender($patient_gender)
            ->groupBy('vaccine_id', 'patient_id', 'patients.gender')
            ->havingRaw('COUNT(vaccine_id) >= ? AND year(vax_date) = ? AND month(vax_date) = ?', [$vaccine_seq, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_mother_vaccine()
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
                        patient_id
                    ")
            ->whereVaccineId('TD')
            ->groupBy('patient_id')
            ->havingRaw('COUNT(vaccine_id) >= 2');
    }

    public function get_cpab($request, $patient_gender)
    {
        return DB::table('patient_ccdevs')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    birthdate,
	                    gender
                    ")
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->joinSub($this->get_mother_vaccine(), 'mother_vaccine', function ($join) {
                $join->on('mother_vaccine.patient_id', '=', 'patient_ccdevs.mothers_id');
            })
            ->whereYear('birthdate', $request->year)
            ->whereMonth('birthdate', $request->month)
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_hepb($request, $gender, $age_day)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    patients.gender,
	                    patients.birthdate,
	                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 1), ',', - 1) AS vax_date,
	                    TIMESTAMPDIFF(day, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 1), ',', - 1)) AS age_day
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->whereVaccineId('HEPB')
            ->where('gender', $gender)
            ->groupBy('patient_id')
            ->when($age_day >= 2, fn($query) => $query->havingRaw('age_day > ? AND year(vax_date) = ? AND month(vax_date) = ?', [$age_day, $request->year, $request->month]))
            ->when($age_day == 0, fn($query) => $query->havingRaw('age_day = ? AND year(vax_date) = ? AND month(vax_date) = ?', [$age_day, $request->year, $request->month]))
            ->orderBy('name', 'ASC');
    }

    public function get_ipv1($request, $patient_gender)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',',1), ',', - 1) AS vax_date
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->whereVaccineId('IPV')
            ->whereStatusId('1')
            ->whereGender($patient_gender)
            ->groupBy('vaccine_id', 'patient_id', 'patients.gender')
            ->havingRaw('COUNT(vaccine_id) >= 1 AND year(vax_date) = ? AND month(vax_date) = ?', [$request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_ipv2($request, $patient_gender, $age_year)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    patients.gender,
	                    patients.birthdate,
	                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1) AS vax_date,
	                    TIMESTAMPDIFF(YEAR, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)) AS age_year,
                        TIMESTAMPDIFF(MONTH, DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1))YEAR), SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)) AS months,
                        TIMESTAMPDIFF(
                            DAY,
                            DATE_ADD(
                                DATE_ADD(
                                    birthdate ,
                                    INTERVAL TIMESTAMPDIFF(YEAR,birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)
                                ) YEAR),
                                INTERVAL TIMESTAMPDIFF(
                                    MONTH,
                                    DATE_ADD(
                                        birthdate ,
                                        INTERVAL TIMESTAMPDIFF(YEAR,birthdate,SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)) YEAR
                                    ),
                                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)
                                ) MONTH
                            ),
                            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 2), ',', - 1)
                        ) AS days
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->whereVaccineId('IPV')
            ->whereStatusId('1')
            ->where('gender', $patient_gender)
            ->groupBy('patient_id')
            ->when($age_year == 0, fn($query) => $query->havingRaw('(age_year = 1 AND (months = 0  AND days = 0) OR age_year < 1) AND year(vax_date) = ? AND month(vax_date) = ?', [$request->year, $request->month]))
            ->when($age_year == 1, fn($query) => $query->havingRaw('(age_year = 1 AND (months > 0 OR days > 0) OR age_year >= 2) AND year(vax_date) = ? AND month(vax_date) = ?', [$request->year, $request->month]))
            ->orderBy('name', 'ASC');
    }

    public function get_fic_cic($request, $patient_gender, $immunization_status)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
                        gender,
                        birthdate,
                        SUM(CASE
                                WHEN vaccine_id = 'BCG'
                                THEN 1
                                ELSE 0
                        END) AS 'BCG',
                        SUM(CASE
                               WHEN vaccine_id = 'PENTA'
                                THEN 1
                                ELSE 0
                        END) AS 'PENTA',
                        SUM(CASE
                                WHEN vaccine_id = 'OPV'
                                THEN 1
                                ELSE 0
                        END) AS 'OPV',
                        SUM(CASE
                                WHEN vaccine_id = 'MCV'
                                THEN 1
                                ELSE 0
                        END) AS 'MCV',
                            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(CASE
                                WHEN vaccine_id = 'MCV'
                                THEN vaccine_date
                                ELSE NULL
                        END ORDER BY vaccine_date ASC),',', 2),',', -1) AS vaccine_date,
                        TIMESTAMPDIFF(MONTH, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(CASE
                            WHEN vaccine_id = 'MCV'
                            THEN vaccine_date
                            ELSE NULL
                        END ORDER BY vaccine_date ASC),',', 2),',', -1)) AS age_month
                ")
                    ->from('patient_vaccines')
                    ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                    ->groupBy('patient_id');
        })
            ->selectRaw('
                name,
                gender,
                vaccine_date,
                CASE
                    WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month < 13
                    THEN "FIC"
                    WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month BETWEEN 13 AND 23
                    THEN "CIC"
                    WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month >= 24
                    THEN "COMPLETED"
	            END AS immunization_status
        ')
            ->whereYear('vaccine_date', $request->year)
            ->whereMonth('vaccine_date', $request->month)
            ->whereGender($patient_gender)
            ->having('immunization_status', '=', [$immunization_status])
            ->orderBy('name', 'ASC');
    }

    public function init_breastfeeding($request, $patient_gender)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        patient_id,
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    gender,
                        breastfeeding,
                        breastfed_date
                    ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->where('breastfeeding', '1')
            ->whereGender($patient_gender)
            ->whereYear('breastfed_date', $request->year)
            ->whereMonth('breastfed_date', $request->month)
            ->orderBy('name', 'ASC');
    }

    public function get_lbw_iron($request, $patient_gender, $age_month)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    gender,
	                    birthdate,
	                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1) AS service_date,
	                    TIMESTAMPDIFF(YEAR, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1)) AS age_year,
                        TIMESTAMPDIFF(MONTH, DATE_ADD(birthdate, INTERVAL TIMESTAMPDIFF(YEAR, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1))YEAR), SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1)) AS months,
                        TIMESTAMPDIFF(
                            DAY,
                            DATE_ADD(
                                DATE_ADD(
                                    birthdate ,
                                    INTERVAL TIMESTAMPDIFF(YEAR,birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1)
                                ) YEAR),
                                INTERVAL TIMESTAMPDIFF(
                                    MONTH,
                                    DATE_ADD(
                                        birthdate ,
                                        INTERVAL TIMESTAMPDIFF(YEAR,birthdate,SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1)) YEAR
                                    ),
                                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1)
                                ) MONTH
                            ),
                            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(service_date ORDER BY service_date ASC), ',', 1), ',', - 1)
                        ) AS days
                    ")
            ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
            ->whereServiceId('IRON')
            ->whereStatusId('1')
            ->where('gender', $patient_gender)
            ->groupBy('patient_id')
            ->when($age_month == 1, fn($query) => $query->havingRaw('(age_year = 0 AND (months BETWEEN 1 AND 3 AND days <= 29)) AND year(service_date) = ? AND month(service_date) = ?', [$request->year, $request->month]))
            ->orderBy('name', 'ASC');
    }

    public function get_vit_a_1st($request, $patient_gender)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    gender,
	                    service_id,
	                    birthdate,
	                    service_date,
	                    TIMESTAMPDIFF(MONTH, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(
				                        CASE WHEN service_id = 'VITA' THEN
                                            service_date
                                        ELSE
                                            NULL
				                        END ORDER BY service_date ASC), ',', 1), ',', - 1)) AS age_months
                    ")
            ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
            ->whereServiceId('VITA')
            ->whereStatusId('1')
            ->whereGender($patient_gender)
            ->groupBy('patient_id', 'service_id', 'service_date')
            ->havingRaw('age_months BETWEEN 6 AND 11 AND year(service_date) = ? AND month(service_date) = ?', [$request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_vit_a_2nd_3rd($request, $patient_gender)
    {
        return DB::table('consult_ccdev_services')
                ->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
                            gender,
                            birthdate,
                            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(
                                        CASE WHEN service_id = 'VITA2' THEN
                                            service_date
                                        ELSE
                                            NULL
                                        END ORDER BY service_date ASC), ',', 1), ',', - 1) AS vita2_service_date,
                            TIMESTAMPDIFF(MONTH, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(
                                            CASE WHEN service_id = 'VITA2' THEN
                                                service_date
                                            ELSE
                                                NULL
                                            END ORDER BY service_date ASC), ',', 1), ',', - 1)) AS vita2_age_month,
                            SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(
                                        CASE WHEN service_id = 'VITA3' THEN
                                            service_date
                                        ELSE
                                            NULL
                                        END ORDER BY service_date ASC), ',', 1), ',', - 1) AS vita3_service_date,
                            TIMESTAMPDIFF(MONTH, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(
                                            CASE WHEN service_id = 'VITA3' THEN
                                                service_date
                                            ELSE
                                                NULL
                                            END ORDER BY service_date ASC), ',', 1), ',', - 1)) AS vita3_age_month
                        ")
            ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
            ->whereIn('service_id', ['VITA2', 'VITA3'])
            ->groupBy('patient_id')
            ->whereGender($patient_gender)
            ->whereStatusId('1')
            ->havingRaw('(vita2_age_month BETWEEN 12 AND 59) AND (vita3_age_month BETWEEN 12 AND 59) AND year(vita3_service_date) = ? AND month(vita3_service_date) = ?', [$request->year, $request->month]);
    }

    public function get_deworming($request, $patient_gender, $param1, $param2)
    {
        return DB::table('medicine_prescriptions')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        prescription_date,
                        TIMESTAMPDIFF(YEAR, birthdate, prescription_date) as age_year
                    ")
            ->join('patients', 'medicine_prescriptions.patient_id', '=', 'patients.id')
            ->whereIn('konsulta_medicine_code', ['ALBED0000000006SUS1400195BOTTL', 'ALBED0000000006SUS1400231BOTTL', 'ALBED0000000006SUS1400379BOTTL', 'ALBED0000000006SUS1400469BOTTL', 'ALBED0000000034TAB490000000000'])
            ->whereGender($patient_gender)
            ->groupBy('patient_id', 'prescription_date')
            ->havingRaw('(age_year BETWEEN ? AND ?) AND (COUNT(patient_id) <= 2) AND year(prescription_date) = ? AND month(prescription_date) = ?', [$param1, $param2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_sick_infant_children($request, $patient_gender, $param1, $param2)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
           	            DATE_FORMAT(consult_date, '%Y-%m-%d') AS consult_date,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'consult_date')
            ->havingRaw('(age_month BETWEEN ? AND ?) AND year(consult_date) = ? AND month(consult_date) = ?', [$param1, $param2, $request->year, $request->month])
            ->orderBy('name', 'ASC');
    }

    public function get_diarrhea_pneumonia($request, $disease, $patient_gender)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
           	            DATE_FORMAT(consult_date, '%Y-%m-%d') AS consult_date,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->when($disease == 'DIARRHEA', fn($query) =>
                                $query->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09','E86.0','E86.1','E86.2','E86.9','K52.9','K58.0','K58.9','K59.1','P78.3'])
                                      ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(consult_date) = ? AND month(consult_date) = ?', [$request->year, $request->month]))
            ->when($disease == 'PNEUMONIA', fn($query) =>
                                $query->whereIn('icd10_code', ['B05.2', 'J10', 'J11', 'J17.1', 'J10.0', 'J10.1', 'J10.8'])
                                      ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(consult_date) = ? AND month(consult_date) = ?', [$request->year, $request->month]))
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'consult_date')
            ->orderBy('name', 'ASC');
    }

    public function get_mnp($request, $service, $patient_gender)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        service_id,
           	            service_date,
           	            quantity,
                        TIMESTAMPDIFF(MONTH, birthdate, service_date) AS age_month
                    ")
            ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
            ->when($service == 'MNP', fn($query) =>
                    $query->whereServiceId('MNP')
                        ->havingRaw('(age_month BETWEEN 6 AND 11) AND (quantity >= 90) AND year(service_date) = ? AND month(service_date) = ?', [$request->year, $request->month]))
            ->when($service == 'MNP2', fn($query) =>
                    $query->whereServiceId('MNP2')
                        ->havingRaw('(age_month BETWEEN 12 AND 23) AND (quantity >= 180) AND year(service_date) = ? AND month(service_date) = ?', [$request->year, $request->month]))
            ->whereGender($patient_gender)
            ->whereStatusId('1')
            ->groupBy('patient_id', 'service_id', 'service_date', 'quantity')
            ->orderBy('name', 'ASC');
    }
}
