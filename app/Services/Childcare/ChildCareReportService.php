<?php

namespace App\Services\Childcare;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class ChildCareReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_mother_vaccine()
    {
        return DB::table('patient_vaccines')
            ->selectRaw('
                        patient_id
                    ')
            ->whereVaccineId('TD')
            ->groupBy('patient_id')
            ->havingRaw('COUNT(vaccine_id) >= 2');
    }

    public function get_cpab($request)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                    patients.gender,
                    CONCAT(patients.last_name, ', ', patients.first_name) as name,
                    patients.birthdate,
                    patients.birthdate AS date_of_service
                ")
                ->from('patient_ccdevs')
                ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
                ->join('users', 'patient_ccdevs.user_id', '=', 'users.id')
                ->joinSub($this->get_mother_vaccine(), 'mother_vaccine', function ($join) {
                    $join->on('mother_vaccine.patient_id', '=', 'patient_ccdevs.mothers_id');
                })
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ccdevs.facility_code', 'patient_ccdevs.patient_id');
                })
                ->whereBetween('patients.birthdate', [$request->start_date, $request->end_date]);
        }, 'subquery') // Alias for the subquery
        ->selectRaw("
                SUM(gender = 'M') AS male_cpab,
                SUM(gender = 'F') AS female_cpab,
                SUM(gender IN ('M', 'F')) AS male_female_cpab
            ")
            ->whereBetween('date_of_service', [
                $request->start_date,
                $request->end_date
            ]);
    }

    public function get_fic_cic($request)
    {
        return DB::table('patients')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patients.immunization_status = 'FIC'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_fic',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patients.immunization_status = 'FIC'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_fic',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patients.immunization_status = 'FIC'
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patients.immunization_status = 'FIC'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_fic',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patients.immunization_status = 'CIC'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_cic',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patients.immunization_status = 'CIC'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_cic',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patients.immunization_status = 'CIC'
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patients.immunization_status = 'CIC'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_cic'
                ")
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patients.facility_code', 'patients.id');
            })
            ->whereBetween('immunization_date', [$request->start_date, $request->end_date]);
    }

    public function get_vaccines($request)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'BCG'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_bcg',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'BCG'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_bcg',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'BCG'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'BCG'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_bcg',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPB'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_hepb',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPB'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_hepb',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPB'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPB'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_hepb',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPBV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_hepbv',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPBV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_hepbv',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPBV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'HEPBV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_hepbv',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_penta1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_penta1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_penta1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_penta2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_penta2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_penta2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_penta3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_penta3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PENTA'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_penta3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_opv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_opv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_opv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_opv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_opv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_opv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_opv3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_opv3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'OPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_opv3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_ipv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_ipv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_ipv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) <= 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_ipv2_routine',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) <= 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_ipv2_routine',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) <= 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) <= 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_ipv2_routine',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) > 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_ipv2_catch_up',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) > 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_ipv2_catch_up',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) > 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'IPV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND TIMESTAMPDIFF(YEAR, patients.birthdate, vaccine_date) > 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_ipv2_catch_up',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_pcv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_pcv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_pcv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_pcv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_pcv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_pcv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_pcv3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_pcv3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'PCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 3 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_pcv3',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'M'
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_mcv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_mcv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_mcv1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_mcv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_mcv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MCV'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 2 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_mcv2',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR1'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_tdgr1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR1'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_tdgr1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR1'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR1'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_tdgr1',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_mrgr',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_mrgr',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_mrgr',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR7'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_tdgr7',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR7'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_tdgr7',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR7'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'TDGR7'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_tdgr7',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR7'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_mrgr7',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR7'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'female_mrgr7',
                            SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR7'
                                    AND patients.gender = 'M'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) + SUM(
                                CASE
                                    WHEN patient_vaccines.vaccine_id = 'MRGR7'
                                    AND patients.gender = 'F'
                                    AND patient_vaccines.status_id = 1
                                    AND (
                                        SELECT COUNT(*)
                                        FROM patient_vaccines pv
                                        WHERE pv.patient_id = patient_vaccines.patient_id
                                        AND pv.vaccine_id = patient_vaccines.vaccine_id
                                        AND COALESCE(pv.vaccine_date, '0000-01-01') <=
                                        COALESCE(patient_vaccines.vaccine_date, '0000-01-01')
                                    ) = 1 THEN 1
                                    ELSE 0
                                END
                            ) AS 'male_female_mrgr7'
                ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    // the last argument is for query if the user is not for provincial report
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vaccines.facility_code', 'patient_vaccines.patient_id');
                })
                ->whereNull('patient_vaccines.deleted_at')
                ->whereBetween('patient_vaccines.vaccine_date', [$request->start_date, $request->end_date]);
        });
    }

    public function init_breastfeeding($request)
    {
        return DB::table('patient_mc_post_registrations')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_init_bfed',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_init_bfed',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_init_bfed'
                ")
                ->join('patient_mc', 'patient_mc_post_registrations.patient_mc_id', '=', 'patient_mc.id')
                ->join('patient_ccdevs', 'patient_mc.patient_id', '=', 'patient_ccdevs.mothers_id')
                ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
                ->join('users', 'patient_mc_post_registrations.user_id', '=', 'users.id')
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_mc_post_registrations.facility_code', 'patient_mc.patient_id');
                })
                ->whereBreastfeeding(1)
                ->whereBetween('patient_mc_post_registrations.breastfed_date', [$request->start_date, $request->end_date]);
    }

    public function get_ccdev_services($request)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'IRON'
                                AND patient_ccdevs.birth_weight < 2.5
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 1 AND 3
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_lbw_iron',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'IRON'
                                AND patient_ccdevs.birth_weight < 2.5
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 1 AND 3
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_lbw_iron',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'IRON'
                                AND patient_ccdevs.birth_weight < 2.5
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 1 AND 3
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'IRON'
                                AND patient_ccdevs.birth_weight < 2.5
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 1 AND 3
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_lbw_iron',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'VITA'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_vit_a',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'VITA'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_vit_a',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'VITA'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'VITA'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_vit_a',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id IN('VITA2', 'VITA3')
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 59
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_vit_a_2nd_3rd',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id IN('VITA2', 'VITA3')
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 59
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_vit_a_2nd_3rd',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id IN('VITA2', 'VITA3')
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 59
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id IN('VITA2', 'VITA3')
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 59
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_vit_a_2nd_3rd',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'MNP'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                AND quantity >= 90
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_mnp',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'MNP'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                AND quantity >= 90
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_mnp',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'MNP'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                AND quantity >= 90
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'MNP'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 6 AND 11
                                AND quantity >= 90
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_mnp',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'MNP2'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 23
                                AND quantity >= 180
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_mnp2',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'MNP2'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 23
                                AND quantity >= 180
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_mnp2',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND service_id = 'MNP2'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 23
                                AND quantity >= 180
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND service_id = 'MNP2'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) BETWEEN 12 AND 23
                                AND quantity >= 180
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_mnp2'
                    ")
                    ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
                    ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
                    ->join('users', 'consult_ccdev_services.user_id', '=', 'users.id')
                    ->tap(function ($query) use ($request) {
                        $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ccdev_services.facility_code', 'consult_ccdev_services.patient_id');
                    })
                    ->whereStatusId('1')
                    ->whereBetween('service_date', [
                        $request->start_date . ' 00:00:00', // Start of the day
                        $request->end_date . ' 23:59:59'    // End of the day
                    ]);
    }

    public function get_mnp($request, $service, $patient_gender)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        service_id,
           	            service_date AS date_of_service,
           	            quantity,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, service_date) AS age_month,
                        municipality_code,
                        barangay_code
                    ")
            ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ccdev_services.user_id', '=', 'users.id')
            /* ->joinSub($this->categoryFilterService->getAllBrgyMunicipalitiesPatient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consult_ccdev_services.patient_id');
            }) */
            /* ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_ccdev_services.facility_code', auth()->user()->facility_code);
            }) */
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ccdev_services.facility_code', 'consult_ccdev_services.patient_id');
            })
            ->where('patients.gender', $patient_gender)
            ->whereBetween('service_date', [
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59'    // End of the day
            ])
            ->whereStatusId('1')
            ->when($service == 'MNP', fn ($query) => $query->whereServiceId('MNP')
                ->havingRaw('(age_month BETWEEN 6 AND 11) AND (quantity >= 90)'))
            ->when($service == 'MNP2', fn ($query) => $query->whereServiceId('MNP2')
                ->havingRaw('(age_month BETWEEN 12 AND 23) AND (quantity >= 180)'))
            ->groupBy('consult_ccdev_services.patient_id', 'service_id', 'service_date', 'quantity', 'municipality_code', 'barangay_code')
            ->orderBy('name', 'ASC');
    }

    public function get_bfed($request)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_ebf',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_ebf',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_ebf',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) BETWEEN 6 AND 11
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_comp_feeding',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) BETWEEN 6 AND 11
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_comp_feeding',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) BETWEEN 6 AND 11
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) BETWEEN 6 AND 11
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_comp_feeding',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND ebf_date IS NULL
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) >= 6
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_comp_feeding_stop_bfed',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND ebf_date IS NULL
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) >= 6
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_comp_feeding_stop_bfed',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND ebf_date IS NULL
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) >= 6
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND bfed_month1 = 1
                                AND bfed_month2 = 1
                                AND bfed_month3 = 1
                                AND bfed_month4 = 1
                                AND ebf_date IS NULL
                                AND comp_fed_date IS NOT NULL
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) >= 6
                                AND comp_fed_date BETWEEN ? AND ?
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_comp_feeding_stop_bfed'
                    ", [
                        //bindings for male_ebf
                        $request->start_date, $request->end_date,
                        //bindings for female_ebf
                        $request->start_date, $request->end_date,
                        //bindings for male_female_ebf
                        $request->start_date, $request->end_date,
                        $request->start_date, $request->end_date,
                        //bindings for male_comp_feeding
                        $request->start_date, $request->end_date,
                        //bindings for female_comp_feeding
                        $request->start_date, $request->end_date,
                        //bindings for male_female_comp_feeding
                        $request->start_date, $request->end_date,
                        $request->start_date, $request->end_date,
                        //bindings for male_comp_feeding_stop_bfed
                        $request->start_date, $request->end_date,
                        //bindings for female_comp_feeding_stop_bfed
                        $request->start_date, $request->end_date,
                        //bindings for male_female_comp_feeding_stop_bfed
                        $request->start_date, $request->end_date,
                        $request->start_date, $request->end_date
            ])
            ->join('patients', 'consult_ccdev_breastfeds.patient_id', '=', 'patients.id')
            ->join('users', 'consult_ccdev_breastfeds.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ccdev_breastfeds.facility_code', 'consult_ccdev_breastfeds.patient_id');
            });
    }

    public function get_vitals($request)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_height_for_age = 'Stunted'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_stunted',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_height_for_age = 'Stunted'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_stunted',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_height_for_age = 'Stunted'
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_height_for_age = 'Stunted'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_stunted',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_height_for_age = 'Wasted'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_wasted',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_height_for_age = 'Wasted'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_wasted',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_height_for_age = 'Wasted'
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_height_for_age = 'Wasted'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_wasted',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_weight_for_age IN('Obese', 'Overweight')
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_overweight_obese',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_weight_for_age IN('Obese', 'Overweight')
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_overweight_obese',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_weight_for_age IN('Obese', 'Overweight')
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_weight_for_age IN('Obese', 'Overweight')
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_overweight_obese',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_weight_for_age = 'Normal'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_normal',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_weight_for_age = 'Normal'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_normal',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND patient_weight_for_age = 'Normal'
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND patient_weight_for_age = 'Normal'
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_normal'
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vitals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vitals.facility_code', 'patient_vitals.patient_id');
            })
            ->whereBetween(DB::raw('patient_age_months'), [0, 59])
//            ->whereBetween(DB::raw('DATE(vitals_date)'), [$request->start_date, $request->end_date]);
            ->whereBetween('vitals_date', [
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59'    // End of the day
            ]);
//            ->whereBetween('vitals_date', [$request->start_date, $request->end_date]);
    }

    public function get_deworming($request)
    {
        return DB::table('medicine_prescriptions')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_deworming_1_to_19',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_deworming_1_to_19',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_deworming_1_to_19',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 4
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_deworming_1_to_4',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 4
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_deworming_1_to_4',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 4
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 4
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_deworming_1_to_4',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 5 AND 9
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_deworming_5_to_9',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 5 AND 9
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_deworming_5_to_9',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 5 AND 9
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 5 AND 9
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_deworming_5_to_9',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 10 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_deworming_10_to_19',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 10 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_deworming_10_to_19',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 10 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 10 AND 19
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_deworming_10_to_19'
            ")
            ->join('patients', 'medicine_prescriptions.patient_id', '=', 'patients.id')
            ->join('users', 'medicine_prescriptions.user_id', '=', 'users.id')
            ->whereIn('konsulta_medicine_code', [
                'ALBED0000000006SUS1400195BOTTL',
                'ALBED0000000006SUS1400231BOTTL',
                'ALBED0000000006SUS1400379BOTTL',
                'ALBED0000000006SUS1400469BOTTL',
                'ALBED0000000034TAB490000000000'
            ])
            ->havingRaw('(COUNT(medicine_prescriptions.patient_id) >= 2)')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'medicine_prescriptions.facility_code', 'medicine_prescriptions.patient_id');
            })
            ->whereNull('medicine_prescriptions.deleted_at')
            ->whereBetween('medicine_prescriptions.prescription_date', [$request->start_date, $request->end_date]);
    }

    public function get_sick_infant_children($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_sick_infant',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_sick_infant',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_sick_infant',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_sick_children',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_sick_children',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_sick_children',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_diarrhea',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_diarrhea',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_diarrhea',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_pneumonia',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_pneumonia',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_pneumonia'
                    ")
            ->join('consult_notes', 'consults.id', '=', 'consult_notes.consult_id')
            ->join('consult_notes_final_dxes', 'consult_notes.id', '=', 'consult_notes_final_dxes.notes_id')
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->whereBetween('consult_date', [
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59'    // End of the day
            ]);
    }

    public function get_sick_infant_children_with_meds($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'M'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                            AND icd10_code IN
                            (
                            'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                            'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                            'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                            'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                            )
                            AND konsulta_medicine_code = 'RETA10000001103CAP310000000000'
                            THEN patients.id
                            ELSE NULL
                        END) AS male_sick_infant_with_vit_a,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'F'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                            AND icd10_code IN
                            (
                            'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                            'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                            'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                            'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                            )
                            AND konsulta_medicine_code = 'RETA10000001103CAP310000000000'
                            THEN patients.id
                            ELSE NULL
                        END) AS female_sick_infant_with_vit_a,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'M'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                            AND icd10_code IN ('A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                               'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                               'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                               'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9')
                            AND konsulta_medicine_code = 'RETA10000001103CAP310000000000'
                            THEN patients.id
                            ELSE NULL
                        END)
                        +
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'F'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11
                            AND icd10_code IN ('A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                               'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                               'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                               'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9')
                            AND konsulta_medicine_code = 'RETA10000001103CAP310000000000'
                            THEN patients.id
                            ELSE NULL
                        END) AS male_female_sick_infant_with_vit_a,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'M'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN
                            (
                            'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                            'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                            'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                            'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                            )
                            AND konsulta_medicine_code IN('VITAA0000000294CAP310000000000', 'RETA10000000294CAP310000000000')
                            THEN patients.id
                            ELSE NULL
                        END) AS male_sick_children_with_vit_a,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'F'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN
                            (
                            'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                            'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                            'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                            'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9'
                            )
                            AND konsulta_medicine_code IN('VITAA0000000294CAP310000000000', 'RETA10000000294CAP310000000000')
                            THEN patients.id
                            ELSE NULL
                        END) AS female_sick_children_with_vit_a,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'M'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN ('A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                               'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                               'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                               'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9')
                            AND konsulta_medicine_code IN ('VITAA0000000294CAP310000000000', 'RETA10000000294CAP310000000000')
                            THEN patients.id
                            ELSE NULL
                        END)
                        +
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'F'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN ('A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                               'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                               'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4',
                                               'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9')
                            AND konsulta_medicine_code IN ('VITAA0000000294CAP310000000000', 'RETA10000000294CAP310000000000')
                            THEN patients.id
                            ELSE NULL
                        END) AS male_female_sick_children_with_vit_a,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'M'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN
                            (
                            'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                            'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                            'B05'
                            )
                            AND konsulta_medicine_code IN
                            (
                            'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                            'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                            'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                            )
                            THEN patients.id
                            ELSE NULL
                        END) AS male_diarrhea_with_ors,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'F'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN
                            (
                            'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                            'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                            'B05'
                            )
                            AND konsulta_medicine_code IN
                            (
                            'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                            'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                            'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                            )
                            THEN patients.id
                            ELSE NULL
                        END) AS female_diarrhea_with_ors,
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'M'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN ('A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                               'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3', 'B05')
                            AND konsulta_medicine_code IN ('ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                                                           'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                                                           'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01')
                            THEN patients.id
                            ELSE NULL
                        END)
                        +
                        COUNT(DISTINCT CASE
                            WHEN patients.gender = 'F'
                            AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59
                            AND icd10_code IN ('A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                               'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3', 'B05')
                            AND konsulta_medicine_code IN ('ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                                                           'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                                                           'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01')
                            THEN patients.id
                            ELSE NULL
                        END) AS male_female_diarrhea_with_ors,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                                'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                                'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL',
                                'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_diarrhea_with_ors_zinc',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                                'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                                'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL',
                                'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_diarrhea_with_ors_zinc',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                                'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                                'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL',
                                'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1', 'P78.3',
                                'B05'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                                'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                                'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL',
                                'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_diarrhea_with_ors_zinc',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000',
                                'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01',
                                'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_pneumonia_with_treatment',
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000',
                                'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01',
                                'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'female_pneumonia_with_treatment',
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000',
                                'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01',
                                'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) + SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59
                                AND icd10_code IN
                                (
                                'B05.2', 'J10', 'J11', 'J17.1',
                                'J10.0', 'J10.1', 'J10.8'
                                )
                                AND konsulta_medicine_code IN
                                (
                                'AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000',
                                'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01',
                                'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'
                                )
                                THEN 1
                                ELSE 0
                            END
                        ) AS 'male_female_pneumonia_with_treatment'
                    ")
            ->join('consult_notes', 'consults.id', '=', 'consult_notes.consult_id')
            ->join('consult_notes_final_dxes', 'consult_notes.id', '=', 'consult_notes_final_dxes.notes_id')
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('medicine_prescriptions', 'consults.id', '=', 'medicine_prescriptions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->whereNull('medicine_prescriptions.deleted_at')
            ->whereBetween('medicine_prescriptions.prescription_date', [$request->start_date, $request->end_date]);
    }
}
