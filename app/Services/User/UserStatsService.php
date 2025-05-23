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
                        COUNT(patients.user_id) AS Count
                    ")
            ->join('patients', 'users.id', '=', 'patients.user_id')
            ->join('lib_designations', 'users.designation_code', '=', 'lib_designations.code')
            ->join('facilities', 'users.facility_code', 'facilities.code')
            ->where('users.facility_code', auth()->user()->facility_code)
            ->whereYear('patients.created_at', $request->year)
            ->whereMonth('patients.created_at', $request->month)
            ->groupBy('name', 'Designation', 'users.facility_code')
            ->orderBy('Count', 'DESC');
    }
}
