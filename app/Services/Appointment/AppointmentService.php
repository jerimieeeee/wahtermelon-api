<?php

namespace App\Services\Appointment;

use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function get_all_appointments()
    {
        return DB::table('appointments')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    appointments.facility_code,
                        lib_appointments.desc AS appointment,
                        appointment_date
                    ")
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('facilities', 'appointments.facility_code', '=', 'facilities.code')
            ->join('lib_appointments', 'appointments.appointment_code', '=', 'lib_appointments.code');
    }
}
