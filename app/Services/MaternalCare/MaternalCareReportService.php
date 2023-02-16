<?php

namespace App\Services\Childcare;

use Illuminate\Support\Facades\DB;

class MaternalCareReportService
{
    public function get_4prenatal_give_birth($request, $count)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        gender,
                        birthdate,
                        DATE_FORMAT(delivery_date, '%Y-%m-%d') AS delivery_date,
                        TIMESTAMPDIFF(YEAR, birthdate, delivery_date) AS age_year
                    ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->whereStatusId('1')
            ->groupBy('patient_id', 'delivery_date')
            ->havingRaw('COUNT(vaccine_id) >= ? AND year(vax_date) = ? AND month(vax_date) = ?', [$request->year, $request->month])
            ->orderBy('name', 'ASC');
    }


}
