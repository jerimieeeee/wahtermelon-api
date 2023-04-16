<?php

namespace App\Services\User;

use Illuminate\Support\Facades\DB;

class UserStatsService
{
    public function get_count_users_registered_patients($request)
    {
        return DB::table('users')
            ->selectRaw("
                        CONCAT(users.first_name, ' ', users.middle_name, ' ', users.last_name) AS Name,
                        lib_designations.desc AS Designation,
                        users.facility_code,
                        COUNT(patients.user_id) AS Count
                    ")
            ->join('patients', 'users.id', '=', 'patients.user_id')
            ->join('lib_designations', 'users.designation_code', '=', 'lib_designations.code')
            ->groupBy('name', 'Designation', 'facility_code')
            ->whereYear('patients.created_at', $request->year)
            ->whereMonth('patients.created_at', $request->month)
            ->orderBy('name', 'ASC');
    }
}
