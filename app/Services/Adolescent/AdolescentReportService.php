<?php

namespace App\Services\Adolescent;

use App\Http\Resources\API\V1\Reports\DailyServiceConsultationReportResource;
use App\Models\V1\Adolescent\ConsultAsrhRapid;
use App\Models\V1\Consultation\Consult;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Services\ReportFilter\CategoryFilterService;

class AdolescentReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_adolescent_report($request)
    {
        return DB::table('patients')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patients.created_at) BETWEEN 10 AND 14
                                AND patients.created_at BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_10_to_14_registered',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patients.created_at) BETWEEN 15 AND 19
                                AND patients.created_at BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_15_to_19_registered',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patients.created_at) BETWEEN 10 AND 14
                                AND patients.created_at BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_10_to_14_registered',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patients.created_at) BETWEEN 15 AND 19
                                AND patients.created_at BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_15_to_19_registered',
                        SUM(
                            CASE
                                WHEN patients.created_at BETWEEN ? AND ?
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patients.created_at) BETWEEN 10 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_total_registered'
                ",
                [
                //male_10_to_14_registered
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59',    // End of the day
                //male_15_to_19_registered
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:58',    // End of the day
                //female_10_to_14_registered
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59',    // End of the day
                //female_15_to_19_registered
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59',    // End of the day
                //male_female_total_registered
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59',    // End of the day
            ])
            ->leftJoin('consult_asrh_rapids', 'patients.id', '=', 'consult_asrh_rapids.patient_id')
            ->join('users', 'patients.user_id', '=', 'users.id')
//            ->where('patients.facility_code', auth()->user()->facility_code);
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patients.facility_code', 'patients.id');
            });
    }
}
