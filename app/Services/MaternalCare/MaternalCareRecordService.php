<?php

namespace App\Services\MaternalCare;

use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;

class MaternalCareRecordService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function getLatestMcRecord(array $request): mixed
    {
        return PatientMc::addSelect([
            'end_pregnancy' => PatientMcPostRegistration::select('end_pregnancy')
                ->whereColumn('patient_mc_id', 'patient_mc.id'),
            'post_registration' => PatientMcPostRegistration::select('post_registration_date')
                ->whereColumn('patient_mc_id', 'patient_mc.id')
                ->where('end_pregnancy', false),
            'pre_registration' => PatientMcPreRegistration::select('pre_registration_date')
                ->whereColumn('patient_mc_id', 'patient_mc.id'),
        ])
            ->havingRaw('(end_pregnancy = 0 OR end_pregnancy IS NULL) AND ((pre_registration IS NULL AND post_registration IS NOT NULL) OR (pre_registration IS NOT NULL AND post_registration IS NULL) OR (pre_registration IS NOT NULL AND post_registration IS NOT NULL))')
            ->wherePatientId($request['patient_id'])
            ->whereNull('pregnancy_termination_code')
            ->latest('post_registration', 'pre_registration')
            ->first();
    }

    /**
     * @return mixed
     */
    public function updateVisitSequence(string $request, string $model, string $column)
    {
        $model = app('App\\Models\\V1\\MaternalCare\\'.$model);
        $visitSequence = $model::where('patient_mc_id', $request)->orderBy($column, 'ASC')->get();
        $visitSequence->map(function ($item, $key) {
            $item->update(['visit_sequence' => $key + 1]);
        });

        return $model::where('patient_mc_id', $request)->orderBy($column, 'DESC')->get();
    }
}
