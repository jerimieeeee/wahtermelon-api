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

    public function get_cpab_namelist($request)
    {
        return DB::table('patient_ccdevs')
            ->selectRaw("
	                    CONCAT(patients.last_name, ',', ' ', patients.first_name) as name,
	                    patients.birthdate,
                        patients.birthdate AS date_of_service,
	                    municipality_code,
	                    barangay_code
                    ")
            ->join('patients', 'patient_ccdevs.patient_id', '=', 'patients.id')
            ->join('users', 'patient_ccdevs.user_id', '=', 'users.id')
            ->joinSub($this->get_mother_vaccine(), 'mother_vaccine', function ($join) {
                $join->on('mother_vaccine.patient_id', '=', 'patient_ccdevs.mothers_id');
            })
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_ccdevs.facility_code', 'patient_ccdevs.patient_id');
            })
            ->when($request->indicator == 'cpab', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender));
            })
            ->whereBetween('patients.birthdate', [$request->start_date, $request->end_date])
            ->orderBy('name', 'ASC');
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
            ->whereBetween('patient_vaccines.vaccine_date', [$request->start_date, $request->end_date])
            ->groupBy('patients.id')
            ->orderBy('name');
    }

    public function get_fic_cic_namelist($request)
    {
        return DB::table(function ($query) use ($request) {
            $query->selectRaw("
                        patients.gender,
                        patient_vaccines.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        SUM(
                            CASE
                                WHEN vaccine_id = 'BCG' THEN 1
                                ELSE 0
                            END
                        ) AS BCG,
                        SUM(
                            CASE
                                WHEN vaccine_id = 'PENTA' THEN 1
                                ELSE 0
                            END
                        ) AS PENTA,
                        SUM(
                            CASE
                                WHEN vaccine_id = 'OPV' THEN 1
                                ELSE 0
                            END
                        ) AS OPV,
                        SUM(
                            CASE
                                WHEN vaccine_id = 'MCV' THEN 1
                                ELSE 0
                            END
                        ) AS MCV,
                        MAX(vaccine_date) AS date_of_service,
                        SUBSTRING_INDEX(
                            GROUP_CONCAT(
                                status_id
                                ORDER BY
                                    vaccine_date DESC
                            ),
                            ',',
                            1
                        ) AS status_id,
                        TIMESTAMPDIFF(MONTH, patients.birthdate, MAX(vaccine_date)) AS age_month
                    ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->join('users', 'patient_vaccines.user_id', '=', 'users.id')
                ->whereIn('patients.gender', ['M', 'F'])
                ->whereIn('patient_vaccines.vaccine_id', ['BCG', 'PENTA', 'OPV', 'MCV'])
                ->tap(function ($query) use ($request) {
                    $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vaccines.facility_code', 'patient_vaccines.patient_id');
                })
                ->groupBy('patient_vaccines.patient_id')
                ->havingRaw('
                            BCG >= 1
                            AND PENTA >=3
                            AND OPV >=3
                            AND MCV >=2
                            AND age_month >= 0
                            AND status_id = 1
                ');
        })
        ->selectRaw("
                    patient_id,
                    name,
                    last_name,
                    first_name,
                    middle_name,
                    birthdate,
                    age_month
        ")
        ->when($request->indicator == 'fic', function ($q) use ($request) {
            $q->whereIn('gender', explode(',', $request->gender))
                ->where('age_month', '<', 13);
        })
        ->when($request->indicator == 'cic', function ($q) use ($request) {
            $q->whereIn('gender', explode(',', $request->gender))
                ->whereBetween('age_month', [13, 23]);
        })
        ->whereBetween('date_of_service', [
            $request->start_date,
            $request->end_date
        ]);
    }

    public function init_breastfeeding_namelist($request)
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
            ->whereBetween('patient_mc_post_registrations.breastfed_date', [$request->start_date, $request->end_date]);
    }

    public function get_ccdev_services_namelist($request)
    {
        return DB::table('consult_ccdev_services')
            ->selectRaw("
                        consult_ccdev_services.patient_id AS patient_id,
                        CONCAT(patients.last_name, ', ', patients.first_name, ', ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
        ")
        ->join('patients', 'consult_ccdev_services.patient_id', '=', 'patients.id')
        ->join('patient_ccdevs', 'consult_ccdev_services.patient_id', '=', 'patient_ccdevs.patient_id')
        ->join('users', 'consult_ccdev_services.user_id', '=', 'users.id')
        ->tap(function ($query) use ($request) {
            $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_ccdev_services.facility_code', 'consult_ccdev_services.patient_id');
        })
        ->when($request->indicator == 'lbw_iron', function ($q) use ($request) {
            $q->whereIn('patients.gender', explode(',', $request->gender))
                ->where('consult_ccdev_services.service_id', 'IRON')
                ->where('patient_ccdevs.birth_weight', '<', 2.5)
                ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consult_ccdev_services.service_date) BETWEEN 1 AND 3');
        })
        ->when($request->indicator == 'vit_a', function ($q) use ($request) {
            $q->whereIn('patients.gender', explode(',', $request->gender))
                ->where('consult_ccdev_services.service_id', 'VITA')
                ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consult_ccdev_services.service_date) BETWEEN 6 AND 11');
        })
        ->when($request->indicator == 'vit_a_2nd_3rd', function ($q) use ($request) {
            $q->whereIn('patients.gender', explode(',', $request->gender))
                ->whereIn('consult_ccdev_services.service_id', ['VITA2', 'VITA3'])
                ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consult_ccdev_services.service_date) BETWEEN 12 AND 59');
        })
        ->when($request->indicator == 'mnp', function ($q) use ($request) {
            $q->whereIn('patients.gender', explode(',', $request->gender))
                ->where('consult_ccdev_services.service_id', 'MNP')
                ->where('consult_ccdev_services.quantity', '>=', 90)
                ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consult_ccdev_services.service_date) BETWEEN 6 AND 11');
        })
        ->when($request->indicator == 'mnp2', function ($q) use ($request) {
            $q->whereIn('patients.gender', explode(',', $request->gender))
                ->where('consult_ccdev_services.service_id', 'MNP2')
                ->where('consult_ccdev_services.quantity', '>=', 180)
                ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consult_ccdev_services.service_date) BETWEEN 12 AND 23');
        })
//        ->whereRaw('TIMESTAMPDIFF(DAY, patients.birthdate, consult_ccdev_services.service_date) <= 29')
        ->where('consult_ccdev_services.status_id', '1')
        ->whereBetween('consult_ccdev_services.service_date', [
            $request->start_date . ' 00:00:00', // Start of the day
            $request->end_date . ' 23:59:59'    // End of the day
        ]);
    }

    public function get_bfed_namelist($request)
    {
        return DB::table('consult_ccdev_breastfeds')
            ->selectRaw("
                        consult_ccdev_breastfeds.patient_id AS patient_id,
                        CONCAT(patients.last_name, ', ', patients.first_name, ', ', patients.middle_name) AS name,
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
            ->when($request->indicator == 'ebf', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('DATE_ADD(DATE_ADD(patients.birthdate, INTERVAL 5 MONTH), INTERVAL 29 DAY) BETWEEN ? AND ?', [$request->start_date, $request->end_date]);
            })
            ->when($request->indicator == 'comp_fed', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereNotnull('comp_fed_date')
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) BETWEEN 6 AND 11')
                    ->whereBetween('comp_fed_date', [
                        $request->start_date . ' 00:00:00', // Start of the day
                        $request->end_date . ' 23:59:59'    // End of the day
                    ]);
            })
            ->when($request->indicator == 'comp_fed_stop_bfed', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereNull('ebf_date')
                    ->whereNotnull('comp_fed_date')
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, comp_fed_date) >= 6')
                    ->whereBetween('comp_fed_date', [
                        $request->start_date . ' 00:00:00', // Start of the day
                        $request->end_date . ' 23:59:59'    // End of the day
                    ]);;
            })
            ->where('consult_ccdev_breastfeds.bfed_month1', 1)
            ->where('consult_ccdev_breastfeds.bfed_month2', 1)
            ->where('consult_ccdev_breastfeds.bfed_month3', 1)
            ->where('consult_ccdev_breastfeds.bfed_month4', 1);
    }

    public function get_vitals_namelist($request)
    {
        return DB::table('patient_vitals')
            ->selectRaw("
                        patient_vitals.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
                    ")
            ->join('patients', 'patient_vitals.patient_id', '=', 'patients.id')
            ->join('users', 'patient_vitals.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_vitals.facility_code', 'patient_vitals.patient_id');
            })
            ->whereBetween(DB::raw('patient_age_months'), [0, 59])
            ->when($request->indicator == 'stunted', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->where('patient_height_for_age', 'Stunted');
            })
            ->when($request->indicator == 'wasted', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->where('patient_height_for_age', 'Wasted');
            })
            ->when($request->indicator == 'overweight_obese', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereIn('patient_weight_for_age', ['Overweight', 'Obese']);
            })
            ->when($request->indicator == 'normal', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->where('patient_weight_for_age', 'Normal');
            })
            ->whereBetween('patient_vitals.vitals_date', [
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59'    // End of the day
            ]);
    }

    public function get_deworming_namelist($request)
    {
        return DB::table('medicine_prescriptions')
            ->selectRaw("
                        medicine_prescriptions.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
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
            ->when($request->indicator == 'deworming_1_to_19', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 19');
            })
            ->when($request->indicator == 'deworming_1_to_4', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 1 AND 4');
            })
            ->when($request->indicator == 'deworming_5_to_9', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 5 AND 9');
            })
            ->when($request->indicator == 'deworming_10_to_19', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(YEAR, patients.birthdate, medicine_prescriptions.prescription_date) BETWEEN 10 AND 19');
            })
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'medicine_prescriptions.facility_code', 'medicine_prescriptions.patient_id');
            })
            ->whereBetween('medicine_prescriptions.prescription_date', [$request->start_date, $request->end_date]);
    }

    public function get_sick_infant_children_namelist($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
                    ")
            ->join('consult_notes', 'consults.id', '=', 'consult_notes.consult_id')
            ->join('consult_notes_final_dxes', 'consult_notes.id', '=', 'consult_notes_final_dxes.notes_id')
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->when($request->indicator == 'sick_infant', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                                'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                                'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1',
                                'P78.3', 'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3',
                                'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8',
                                'B06.9'
                        ]);
            })
            ->when($request->indicator == 'sick_children', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                        'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1',
                        'P78.3', 'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3',
                        'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8',
                        'B06.9'
                    ]);
            })
            ->when($request->indicator == 'diarrhea', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                        'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1',
                        'P78.3', 'B05'
                    ]);
            })
            ->when($request->indicator == 'pneumonia', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'B05.2', 'J10', 'J11', 'J17.1',
                        'J10.0', 'J10.1', 'J10.8'
                    ]);
            })
            ->whereBetween('consult_date', [
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59'    // End of the day
            ]);
    }

    public function get_sick_infant_children_with_meds_namelist($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
                    ")
            ->join('consult_notes', 'consults.id', '=', 'consult_notes.consult_id')
            ->join('consult_notes_final_dxes', 'consult_notes.id', '=', 'consult_notes_final_dxes.notes_id')
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('medicine_prescriptions', 'consults.id', '=', 'medicine_prescriptions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->when($request->indicator == 'sick_infant_with_vit_a', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 6 AND 11')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                        'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1',
                        'P78.3', 'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3',
                        'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8',
                        'B06.9'
                    ])
                    ->where('konsulta_medicine_code', 'RETA10000001103CAP310000000000');
            })
            ->when($request->indicator == 'sick_children_with_vit_a', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 12 AND 59')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                        'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1',
                        'P78.3', 'B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3',
                        'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8',
                        'B06.9'
                    ])
                    ->whereIn('konsulta_medicine_code', ['VITAA0000000294CAP310000000000', 'RETA10000000294CAP310000000000']);
            })
            ->when($request->indicator == 'diarrhea_with_ors', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                        'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1',
                        'P78.3', 'B05'
                    ])
                    ->whereIn('konsulta_medicine_code', [
                        'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                        'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                        'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                    ]);
            })
            ->when($request->indicator == 'diarrhea_with_ors_zinc', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'A06', 'A06.0', 'A06.1', 'A09', 'E86.0', 'E86.1',
                        'E86.2', 'E86.9', 'K52.9', 'K58.0', 'K58.9', 'K59.1',
                        'P78.3', 'B05'
                    ])
                    ->whereIn('konsulta_medicine_code', [
                        'ORAL20000000000POW2701273SAC01', 'ORAL20000000000POW2701279SAC01',
                        'ORAL20000000000POW2701323SAC01', 'ORAL20000000000POW2701426SAC01',
                        'ORAL20000000000SOL3200020BOTTL', 'ORAL20000000483POW2700000SAC01'
                    ])
                    ->whereIn('konsulta_medicine_code', [
                        'ZINCX0000001335OD00000231BOTTL', 'ZINCX0000001336SYRUP00469BOTTL',
                        'ZINCX0000001344SYRUP00201BOTTL', 'ZINCX0000001344SYRUP00469BOTTL'
                    ]);
            })
            ->when($request->indicator == 'pneumonia_with_treatment', function ($q) use ($request) {
                $q->whereIn('patients.gender', explode(',', $request->gender))
                    ->whereRaw('TIMESTAMPDIFF(MONTH, patients.birthdate, consults.consult_date) BETWEEN 0 AND 59')
                    ->whereIn('consult_notes_final_dxes.icd10_code', [
                        'B05.2', 'J10', 'J11', 'J17.1',
                        'J10.0', 'J10.1', 'J10.8'
                    ])
                    ->whereIn('konsulta_medicine_code', [
                        'AMOX50005700015CAPSU0000000000', 'AMOX50005700047CAPSU0000000000',
                        'AMOX50005700142SUS1400195DRO01', 'AMOX50005700142SUS1400231DRO01',
                        'AMOX50005700209SUS1400379BOTTL', 'AMOX50005700209SUS1400469BOTTL'
                    ]);
            })
            ->whereBetween('medicine_prescriptions.prescription_date', [$request->start_date, $request->end_date]);
    }
}
