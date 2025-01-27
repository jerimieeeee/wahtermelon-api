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
            ->when($request->vaccine_id == 'IPV', function ($q) use ($request) {
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
                            ->where('patient_vaccines.vaccine_id', $request->vaccine_id)
                            ->where('patient_vaccines.status_id', 1);
                    })
                    ->when($request->gender == 'female', function ($q) use ($request) {
                        $q->where('patients.gender', 'F')
                            ->where('patient_vaccines.vaccine_id', $request->vaccine_id)
                            ->where('patient_vaccines.status_id', 1);
                    })
                    ->when($request->gender == 'male_female', function ($q) use ($request) {
                        $q->whereIn('patients.gender', ['M', 'F'])
                            ->where('patient_vaccines.vaccine_id', $request->vaccine_id)
                            ->where('patient_vaccines.status_id', 1);
                    });
                });
            })
            ->when($request->gender == 'male', function ($q) use ($request) {
                $q->where('patients.gender', 'M')
                    ->where('patient_vaccines.vaccine_id', $request->vaccine_id)
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
                    ->where('patient_vaccines.vaccine_id', $request->vaccine_id)
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
                    ->where('patient_vaccines.vaccine_id', $request->vaccine_id)
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
}
