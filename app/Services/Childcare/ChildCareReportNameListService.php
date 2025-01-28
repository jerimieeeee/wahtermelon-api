<?php

namespace App\Services\Childcare;
use App\Services\ReportFilter\CategoryFilterService;

use Illuminate\Support\Facades\DB;

class ChildCareReportNameListService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_vaccines_report_namelist($request)
    {
        return DB::table('patient_vaccines')
            ->selectRaw("
                        patient_vaccines.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
                        ")
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
            ->when($request->indicator == 'IPV', function ($q) use ($request) {
                $q->when($request->sequence == 2, function ($q) use ($request) {
                    $q->when($request->routine == 1, function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) <= 1");
                    })
                    ->when($request->routine == 0, function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) > 1");
                    });
                    $q->whereRaw("
                              (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date
                            ) = 2
                    ")
                    ->when($request->gender == 'male', function ($q) use ($request) {
                        $q->where('patients.gender', 'M')
                            ->where('patient_vaccines.vaccine_id', $request->indicator)
                            ->where('patient_vaccines.status_id', 1);
                    })
                    ->when($request->gender == 'female', function ($q) use ($request) {
                        $q->where('patients.gender', 'F')
                            ->where('patient_vaccines.vaccine_id', $request->indicator)
                            ->where('patient_vaccines.status_id', 1);
                    })
                    ->when($request->gender == 'male_female', function ($q) use ($request) {
                        $q->whereIn('patients.gender', ['M', 'F'])
                            ->where('patient_vaccines.vaccine_id', $request->indicator)
                            ->where('patient_vaccines.status_id', 1);
                    });
                });
            })
            ->when($request->gender == 'male', function ($q) use ($request) {
                $q->where('patients.gender', 'M')
                    ->where('patient_vaccines.vaccine_id', $request->indicator)
                    ->where('patient_vaccines.status_id', 1)
                    ->whereRaw("
                              (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date
                            ) = ?
                ", [$request->sequence]);
            })
            ->when($request->gender == 'female', function ($q) use ($request) {
                $q->where('patients.gender', 'F')
                    ->where('patient_vaccines.vaccine_id', $request->indicator)
                    ->where('patient_vaccines.status_id', 1)
                    ->whereRaw("
                              (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date
                            ) = ?
                ", [$request->sequence]);
            })
            ->when($request->gender == 'male_female', function ($q) use ($request) {
                $q->whereIn('patients.gender', ['M', 'F'])
                    ->where('patient_vaccines.vaccine_id', $request->indicator)
                    ->where('patient_vaccines.status_id', 1)
                    ->whereRaw("
                              (
                                SELECT
                                    COUNT(*)
                                FROM
                                    patient_vaccines pv
                                WHERE
                                    pv.patient_id = patient_vaccines.patient_id
                                    AND pv.vaccine_id = patient_vaccines.vaccine_id
                                    AND pv.vaccine_date <= patient_vaccines.vaccine_date
                            ) = ?
                ", [$request->sequence]);
            })
            ->tap(function ($query) use ($request) {
                // the last argument is for query if the user is not for provincial report
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vaccines.facility_code', 'patient_vaccines.patient_id');
            })
            ->whereBetween(DB::raw('DATE(vaccine_date)'), [$request->start_date, $request->end_date])
            ->groupBy('patients.id')
            ->orderBy('name');
    }

    public function init_breastfeeding($request)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        patient_mc.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
                ")
            ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->join('patient_ccdevs', 'patient_mc.patient_id', '=', 'patient_ccdevs.mothers_id')
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_mc_post_registrations.facility_code', 'patient_mc.patient_id');
            })
            ->when($request->indicator == 'male_init_bfed', function ($q) use ($request) {
                $q->where('patients.gender', 'M');
            })
            ->when($request->indicator == 'female_init_bfed', function ($q) use ($request) {
                $q->where('patients.gender', 'F');
            })
            ->when($request->indicator == 'male_female_init_bfed', function ($q) use ($request) {
                $q->whereIn('patients.gender', ['M', 'F']);
            })
            ->whereBreastfeeding(1)
            ->whereBetween(DB::raw('DATE(breastfed_date)'), [$request->start_date, $request->end_date]);
    }

    public function get_bfed($request)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        patient_mc.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
            ")
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ccdev_breastfeds.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ccdev_breastfeds.facility_code', 'consult_ccdev_breastfeds.patient_id');
            })
            ->when($request->indicator == 'male_ebf', function ($q) use ($request) {
                $q->where('patients.gender', 'M');
            })
            ->when($request->indicator == 'male_init_bfed', function ($q) use ($request) {
                $q->where('patients.gender', 'M');
            })
            ->when($request->indicator == 'male_init_bfed', function ($q) use ($request) {
                $q->where('patients.gender', 'M');
            })
            ->where('consult_ccdev_breastfeds.bfed');
    }
}
