<?php

namespace App\Services\MaternalCare;

use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use http\Env\Request;

class MaternalCareRecordService
{
    /**
     * @param array $request
     * @return mixed
     */
    public function getLatestMcRecord(array $request): mixed
    {
        return PatientMc::addSelect([
                'end_pregnancy' => PatientMcPostRegistration::select('end_pregnancy')
                    ->whereColumn('patient_mc_id', 'patient_mc.id'),
                'post_registration' => PatientMcPostRegistration::select('post_registration_date')
                    ->whereColumn('patient_mc_id', 'patient_mc.id')
                    ->where('end_pregnancy', false),
                'pre_registration' => PatientMcPreRegistration::select('pre_registration_date')
                    ->whereColumn('patient_mc_id', 'patient_mc.id')
            ])
            ->havingRaw('(end_pregnancy = 0 OR end_pregnancy IS NULL) AND ((pre_registration IS NULL AND post_registration IS NOT NULL) OR (pre_registration IS NOT NULL AND post_registration IS NULL) OR (pre_registration IS NOT NULL AND post_registration IS NOT NULL))')
            ->wherePatientId($request['patient_id'])
            ->latest('post_registration', 'pre_registration')
            ->first();
    }

}
