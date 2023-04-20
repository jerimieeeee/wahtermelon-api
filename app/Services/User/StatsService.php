<?php

namespace App\Services\User;

use Illuminate\Support\Facades\DB;

class StatsService
{
    public function get_users_birthday_celebrants()
    {
        return DB::table('users')
            ->selectRaw("
                        CONCAT(users.first_name, ' ', users.middle_name, ' ', users.last_name) AS name
                    ")
            ->whereRaw("DATE_FORMAT(birthdate, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')")
            ->orderBy('name', 'ASC');
    }

    public function get_patient_birthday_celebrants()
    {
        return DB::table('patients')
            ->selectRaw("
                        CONCAT(patients.first_name, ' ', patients.middle_name, ' ', patients.last_name) AS name
                    ")
            ->whereRaw("DATE_FORMAT(birthdate, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')")
            ->orderBy('name', 'ASC');
    }
}
