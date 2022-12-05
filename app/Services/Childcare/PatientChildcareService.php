<?php

namespace App\Services\Childcare;

use Illuminate\Support\Facades\DB;

class PatientChildcareService
{
    public function get_status($patient_id)
    {

        // $vax = $this->get_cpab_status($patient_id);

    }

    public function get_cpab_status($motherId)
    {

        return DB::table(function ($query) use($motherId){
            $query->selectRaw('
                patient_id, vaccine_id,
                COUNT(vaccine_id) AS count
            ')
            ->from('patient_vaccines')
            ->wherePatientId($motherId)
            ->groupBy('patient_id','vaccine_id')
            ->havingRaw('count(patient_id)  >= 2');

        })
        ->selectRaw('
                patient_id AS mothersId, "CPAB" AS status
        ')
        ->where('vaccine_id', 'TD');

    }

}
