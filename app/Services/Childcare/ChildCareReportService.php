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
            ->joinSub($this->get_mother_vaccine(),'mother_vaccine', function($join) {
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
	                    TIMESTAMPDIFF(DAY, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(vaccine_date ORDER BY vaccine_date ASC), ',', 1), ',', - 1)) AS age_day
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->whereVaccineId('HEPB')
            ->where('gender', $gender)
            ->groupBy('patient_id')
            ->when($age_day == 2, fn($query) => $query->havingRaw('age_day >= ? AND year(vax_date) = ? AND month(vax_date) = ?', [$age_day, $request->year, $request->month]))
            ->when($age_day == 0, fn($query) => $query->havingRaw('age_day = ? AND year(vax_date) = ? AND month(vax_date) = ?', [$age_day, $request->year, $request->month]))
            ->orderBy('name', 'ASC');
    }
 }
