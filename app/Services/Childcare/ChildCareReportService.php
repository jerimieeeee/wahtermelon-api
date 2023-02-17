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
	                    gender,
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
	                    gender,
	                    birthdate,
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

    public function get_sick_infant_children_with_vit_a($request, $patient_gender, $age_month)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        prescription_date,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09','E86.0','E86.1','E86.2','E86.9','K52.9','K58.0','K58.9','K59.1','P78.3',
                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'])
            ->when($age_month == 6, fn($query) =>
                    $query->whereKonsultaMedicineCode('RETA10000001103CAP310000000000')
                         ->havingRaw('(age_month BETWEEN 6 AND 11) AND year(prescription_date) = ? AND month(prescription_date) = ?', [$request->year, $request->month])
                    )
            ->when($age_month == 12, fn($query) =>
                    $query->whereKonsultaMedicineCode('VITAA0000000294CAP310000000000')
                        ->havingRaw('(age_month BETWEEN 12 AND 59) AND year(prescription_date) = ? AND month(prescription_date) = ?', [$request->year, $request->month])
                    )
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'prescription_date')
            ->orderBy('name', 'ASC');
    }

    public function get_diarrhea_ors_and_ors_with_zinc($request, $patient_gender, $medicine)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        prescription_date,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->whereIn('icd10_code', ['A06', 'A06.0', 'A06.1', 'A09','E86.0','E86.1','E86.2','E86.9','K52.9','K58.0','K58.9','K59.1','P78.3'])
            ->when($medicine == 'ORS', fn($query) =>
            $query->whereIn('konsulta_medicine_code', ['ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01', 'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01', 'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'])
                ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(prescription_date) = ? AND month(prescription_date) = ?', [$request->year, $request->month])
            )
            ->when($medicine == 'ORS WITH ZINC', fn($query) =>
                    $query->whereIn('konsulta_medicine_code', ['ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01', 'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01', 'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'])
                          ->whereIn('konsulta_medicine_code', ['ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL', 'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'])
                          ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(prescription_date) = ? AND month(prescription_date) = ?', [$request->year, $request->month])
            )
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'prescription_date')
            ->orderBy('name', 'ASC');
    }

    public function get_ebf($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        DATE_ADD(DATE_ADD(birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) as ebf_date
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->where(fn($query) =>
                    $query->where([
                            ['bfed_month1', '=', '1'],
                            ['bfed_month2', '=', '1'],
                            ['bfed_month3', '=', '1'],
                            ['bfed_month4', '=', '1']
                    ])
                )
            ->havingRaw('DATE_ADD(DATE_ADD(birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) AND year(ebf_date) = ? AND month(ebf_date) = ?', [$request->year, $request->month])
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
                        prescription_date,
                        TIMESTAMPDIFF(MONTH, birthdate, consult_date) AS age_month
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('medicine_prescriptions', 'consult_notes.patient_id', '=', 'medicine_prescriptions.patient_id')
            ->whereIn('icd10_code', ['B05.2', 'J10', 'J11', 'J17.1', 'J10.0', 'J10.1', 'J10.8'])
            ->when($disease == 'PNEUMONIA', fn($query) =>
                $query->whereIn('konsulta_medicine_code', ['AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000', 'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01', 'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'])
                      ->havingRaw('(age_month BETWEEN 0 AND 59) AND year(prescription_date) = ? AND month(prescription_date) = ?', [$request->year, $request->month])
                )
            ->whereGender($patient_gender)
            ->groupBy('patients.id', 'age_month', 'prescription_date')
            ->orderBy('name', 'ASC');
    }

    public function get_overweight_obese($request, $patient_gender, $class)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        CASE
                            WHEN patient_weight_for_age = 'Overweight'
                            THEN 'Overweight'
                            END AS 'bmi_overweight',
                        CASE
                            WHEN patient_weight_for_age = 'Obese'
                            THEN 'Obese'
                            END AS 'bmi_obese',
                        CASE
                            WHEN patient_weight_for_age = 'Normal'
                            THEN 'Normal'
                            ELSE NULL
                            END AS 'bmi_normal',
                            DATE_FORMAT(vitals_date, '%Y-%m-%d') AS vitals_date,
                            patient_age_months
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->when($class == 'overweight/obese', fn($query) =>
                $query->whereIn('patient_weight_for_age', ['Overweight', 'Obese'])
                )
            ->when($class == 'normal', fn($query) =>
                $query->where('patient_weight_for_age', 'normal')
                )
            ->groupBy('patient_id', 'patient_weight_for_age', 'vitals_date', 'patient_age_months')
            ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND year(vitals_date) = ? AND month(vitals_date) = ?', [$request->year, $request->month])
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_complimentary_feeding($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        comp_fed_date,
                        TIMESTAMPDIFF(MONTH, birthdate, comp_fed_date) AS age_month
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->where(fn($query) =>
                    $query->where([
                        ['bfed_month1', '=', '1'],
                        ['bfed_month2', '=', '1'],
                        ['bfed_month3', '=', '1'],
                        ['bfed_month4', '=', '1']
                    ])
                        ->whereNotNull('ebf_date')
                        ->whereNotNull('comp_fed_date')
            )
            ->havingRaw('(age_month >= 6) AND year(comp_fed_date) = ? AND month(comp_fed_date) = ?', [$request->year, $request->month])
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_complimentary_feeding_stop_bfed($request, $patient_gender)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        comp_fed_date,
                        TIMESTAMPDIFF(MONTH, birthdate, comp_fed_date) AS age_month
                    ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->whereNull('ebf_date')
            ->whereNotNull('comp_fed_date')
            ->havingRaw('(age_month >= 6) AND year(comp_fed_date) = ? AND month(comp_fed_date) = ?', [$request->year, $request->month])
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

    public function get_stunted_wasted($request, $patient_gender, $class)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        DATE_FORMAT(vitals_date, '%Y-%m-%d') AS vitals_date,
                        patient_age_months,
                        patient_height_for_age AS height_for_age
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->when($class == 'Stunted', fn($query) =>
                    $query->whereIn('patient_height_for_age', ['Stunted', 'Severely Stunted'])
                          ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND year(vitals_date) = ? AND month(vitals_date) = ?', [$request->year, $request->month])
                 )
            ->when($class == 'Wasted', fn($query) =>
                    $query->wherePatientHeightForAge($class)
                          ->havingRaw('(patient_age_months BETWEEN 0 AND 59) AND year(vitals_date) = ? AND month(vitals_date) = ?', [$request->year, $request->month])
                 )
            ->whereGender($patient_gender)
            ->orderBy('name', 'ASC');
    }

}
