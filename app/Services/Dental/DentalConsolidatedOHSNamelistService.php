<?php

namespace App\Services\Dental;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Support\Facades\DB;

class DentalConsolidatedOHSNamelistService
{
    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_medical_hx($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_medical_socials', 'dental_oral_health_conditions.patient_id', '=', 'dental_medical_socials.patient_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->when($request->indicator == 'pregnant', function ($q) use ($request) {
                $q->when($request->age == '10', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14");
                    })
                    ->when($request->age == '15', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19");
                    })
                    ->when($request->age == '20', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49");
                    })
                    ->where('patients.gender', 'F')
                    ->where('consults.is_pregnant', 1)
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'tattoo', function ($q) use ($request) {
                        $q->where('tattoo_flag', 1);
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                    ->when($request->params == 'alcohol', function ($q) use ($request) {
                        $q->where('alcohol_flag', 1);
                    })
                    ->when($request->params == 'tobacco', function ($q) use ($request) {
                        $q->where('tabacco_flag', 1);
                    })
                    ->when($request->params == 'nut', function ($q) use ($request) {
                        $q->where('nut_flag', 1);
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    });
            })
            ->when($request->indicator == 'infant', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11")
                    ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    });
            })
            ->when($request->indicator == 'underfive', function ($q) use ($request) {
                $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->age == '1', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1");
                    })
                    ->when($request->age == '2', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2");
                    })
                    ->when($request->age == '3', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3");
                    })
                    ->when($request->age == '4', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4");
                    })
                    ->when($request->age == 'total', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4");
                    })
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    });
            })
            ->when($request->indicator == 'school_age', function ($q) use ($request) {
                $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->age == '5', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5");
                    })
                    ->when($request->age == '6', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6");
                    })
                    ->when($request->age == '7', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7");
                    })
                    ->when($request->age == '8', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8");
                    })
                    ->when($request->age == '9', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9");
                    })
                    ->when($request->age == 'total', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9");
                    })
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'tattoo', function ($q) use ($request) {
                        $q->where('tattoo_flag', 1);
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                   ->when($request->params == 'alcohol', function ($q) use ($request) {
                        $q->where('alcohol_flag', 1);
                    })
                    ->when($request->params == 'tobacco', function ($q) use ($request) {
                        $q->where('tabacco_flag', 1);
                    })
                    ->when($request->params == 'nut', function ($q) use ($request) {
                        $q->where('nut_flag', 1);
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    });
            })
            ->when($request->indicator == 'adolescent', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19")
                    ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'tattoo', function ($q) use ($request) {
                        $q->where('tattoo_flag', 1);
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                    ->when($request->params == 'alcohol', function ($q) use ($request) {
                        $q->where('alcohol_flag', 1);
                    })
                    ->when($request->params == 'tobacco', function ($q) use ($request) {
                        $q->where('tabacco_flag', 1);
                    })
                    ->when($request->params == 'nut', function ($q) use ($request) {
                        $q->where('nut_flag', 1);
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    });
            })
            ->when($request->indicator == 'adult', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59")
                    ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'tattoo', function ($q) use ($request) {
                        $q->where('tattoo_flag', 1);
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                    ->when($request->params == 'alcohol', function ($q) use ($request) {
                        $q->where('alcohol_flag', 1);
                    })
                    ->when($request->params == 'tobacco', function ($q) use ($request) {
                        $q->where('tabacco_flag', 1);
                    })
                    ->when($request->params == 'nut', function ($q) use ($request) {
                        $q->where('nut_flag', 1);
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    });
            })
            ->when($request->indicator == 'senior', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60")
                    ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'tattoo', function ($q) use ($request) {
                        $q->where('tattoo_flag', 1);
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                    ->when($request->params == 'alcohol', function ($q) use ($request) {
                        $q->where('alcohol_flag', 1);
                    })
                    ->when($request->params == 'tobacco', function ($q) use ($request) {
                        $q->where('tabacco_flag', 1);
                    })
                    ->when($request->params == 'nut', function ($q) use ($request) {
                        $q->where('nut_flag', 1);
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    });
            })
            ->when($request->indicator == 'all_age', function ($q) use ($request) {
                $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->params == 'allergies', function ($q) use ($request) {
                        $q->where('allergies_flag', 1);
                    })
                    ->when($request->params == 'hypertension', function ($q) use ($request) {
                        $q->where('hypertension_flag', 1);
                    })
                    ->when($request->params == 'diabetes', function ($q) use ($request) {
                        $q->where('diabetes_flag', 1);
                    })
                    ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                        $q->where('blood_disorder_flag', 1);
                    })
                    ->when($request->params == 'heart_disease', function ($q) use ($request) {
                        $q->where('heart_disease_flag', 1);
                    })
                    ->when($request->params == 'thyroid', function ($q) use ($request) {
                        $q->where('thyroid_flag', 1);
                    })
                    ->when($request->params == 'hepatitis', function ($q) use ($request) {
                        $q->where('hepatitis_flag', 1);
                    })
                    ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                        $q->where('malignancy_flag', 1);
                    })
                    ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                        $q->where('blood_transfusion_flag', 1);
                    })
                    ->when($request->params == 'tattoo', function ($q) use ($request) {
                        $q->where('tattoo_flag', 1)
                            ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");
                    })
                    ->when($request->params == 'sweet', function ($q) use ($request) {
                        $q->where('sweet_flag', 1);
                    })
                    ->when($request->params == 'alcohol', function ($q) use ($request) {
                        $q->where('alcohol_flag', 1)
                            ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");;
                    })
                    ->when($request->params == 'tobacco', function ($q) use ($request) {
                        $q->where('tabacco_flag', 1)
                            ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");;
                    })
                    ->when($request->params == 'nut', function ($q) use ($request) {
                        $q->where('nut_flag', 1)
                            ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");;
                    })
                    ->when($request->params == 'dental_carries', function ($q) use ($request) {
                        $q->where('dental_caries_flag', 1);
                    })
                    ->when($request->params == 'gingivitis', function ($q) use ($request) {
                        $q->where('gingivitis_flag', 1);
                    })
                    ->when($request->params == 'periodontal', function ($q) use ($request) {
                        $q->where('periodontal_flag', 1);
                    })
                    ->when($request->params == 'debris', function ($q) use ($request) {
                        $q->where('debris_flag', 1);
                    })
                    ->when($request->params == 'calculus', function ($q) use ($request) {
                        $q->where('calculus_flag', 1);
                    })
                    ->when($request->params == 'dento_facial', function ($q) use ($request) {
                        $q->where('dento_facial_flag', 1);
                    })
            ->when($request->indicator == 'grand_total', function ($q) use ($request) {
                $q->when($request->params == 'allergies', function ($q) use ($request) {
                    $q->where('allergies_flag', 1);
                })
                ->when($request->params == 'hypertension', function ($q) use ($request) {
                    $q->where('hypertension_flag', 1);
                })
                ->when($request->params == 'diabetes', function ($q) use ($request) {
                    $q->where('diabetes_flag', 1);
                })
                ->when($request->params == 'blood_disorder', function ($q) use ($request) {
                    $q->where('blood_disorder_flag', 1);
                })
                ->when($request->params == 'heart_disease', function ($q) use ($request) {
                    $q->where('heart_disease_flag', 1);
                })
                ->when($request->params == 'thyroid', function ($q) use ($request) {
                    $q->where('thyroid_flag', 1);
                })
                ->when($request->params == 'hepatitis', function ($q) use ($request) {
                    $q->where('hepatitis_flag', 1);
                })
                ->when($request->params == 'malignancy_flag', function ($q) use ($request) {
                    $q->where('malignancy_flag', 1);
                })
                ->when($request->params == 'blood_transfusion', function ($q) use ($request) {
                    $q->where('blood_transfusion_flag', 1);
                })
                ->when($request->params == 'tattoo', function ($q) use ($request) {
                    $q->where('tattoo_flag', 1)
                        ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");
                })
                ->when($request->params == 'sweet', function ($q) use ($request) {
                    $q->where('sweet_flag', 1);
                })
                ->when($request->params == 'alcohol', function ($q) use ($request) {
                    $q->where('alcohol_flag', 1)
                        ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");
                })
                ->when($request->params == 'tobacco', function ($q) use ($request) {
                    $q->where('tabacco_flag', 1)
                        ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");
                })
                ->when($request->params == 'nut', function ($q) use ($request) {
                    $q->where('nut_flag', 1)
                        ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 4");
                })
                ->when($request->params == 'dental_carries', function ($q) use ($request) {
                    $q->where('dental_caries_flag', 1);
                })
                ->when($request->params == 'gingivitis', function ($q) use ($request) {
                    $q->where('gingivitis_flag', 1);
                })
                ->when($request->params == 'periodontal', function ($q) use ($request) {
                    $q->where('periodontal_flag', 1);
                })
                ->when($request->params == 'debris', function ($q) use ($request) {
                    $q->where('debris_flag', 1);
                })
                ->when($request->params == 'calculus', function ($q) use ($request) {
                    $q->where('calculus_flag', 1);
                })
                ->when($request->params == 'dento_facial', function ($q) use ($request) {
                    $q->where('dento_facial_flag', 1);
                });
            })
            ->whereIn('patients.gender', explode(',', $request->gender))
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date]);
        });
    }

    public function get_temporary_tooth_condition($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                        COUNT(patients.id) AS tooth_count
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->when($request->indicator == 'infant', function ($q) use ($request) {
                $q->when($request->params == 'temp_decayed', function ($q) use ($request) {
                        $q->where('tooth_condition', 'D')
                            ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11");
                    })
                    ->when($request->params == 'temp_filled', function ($q) use ($request) {
                        $q->where('tooth_condition', 'F')
                            ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11");
                    })
                    ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'underfive', function ($q) use ($request) {
                $q->when($request->params == 'temp_decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'temp_filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->when($request->age == '1', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1");
                })
                ->when($request->age == '2', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2");
                })
                ->when($request->age == '3', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3");
                })
                ->when($request->age == '4', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4");
                })
                ->when($request->age == 'total', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4");
                })
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'school_age', function ($q) use ($request) {
                $q->when($request->params == 'temp_decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'temp_filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->when($request->age == '5', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5");
                })
                ->when($request->age == '6', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6");
                })
                ->when($request->age == '7', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7");
                })
                ->when($request->age == '8', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8");
                })
                ->when($request->age == '9', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9");
                })
                ->when($request->age == 'total', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9");
                })
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'adolescent', function ($q) use ($request) {
                $q->when($request->params == 'temp_decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'temp_filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19")
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'total', function ($q) use ($request) {
                $q->when($request->params == 'temp_decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'temp_filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19")
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'grand_total', function ($q) use ($request) {
                $q->when($request->params == 'temp_decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'temp_filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19")
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->whereIn('dental_tooth_conditions.tooth_number',
                [
                    '51', '52', '53', '54', '55',
                    '61', '62', '63', '64', '65',
                    '81', '82', '83', '84', '85',
                    '71', '72', '73', '74', '75'
                ]
            )
            ->whereIn('patients.gender', explode(',', $request->gender))
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->groupBy('patients.id');
    }

    public function get_adult_tooth_condition($request)
    {
        return DB::table('consults')
            ->selectRaw("
                    consults.patient_id AS patient_id,
                    CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                    patients.last_name,
                    patients.first_name,
                    patients.middle_name,
                    patients.birthdate,
                    DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                    COUNT(patients.id) AS tooth_count
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->when($request->indicator == 'pregnant', function ($q) use ($request) {
                $q->when($request->params == 'decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'missing', function ($q) use ($request) {
                    $q->where('tooth_condition', 'M');
                })
                ->when($request->params == 'filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->where('consults.is_pregnant', 1)
                ->where('patients.gender', 'F')
                ->when($request->age == '10-14', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14");
                })
                ->when($request->age == '15-19', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19");
                })
                ->when($request->age == '20-49', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49");
                });
            })
            ->when($request->indicator == 'school_age', function ($q) use ($request) {
                $q->when($request->params == 'decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'missing', function ($q) use ($request) {
                    $q->where('tooth_condition', 'M');
                })
                ->when($request->params == 'filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->when($request->age == '5', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5");
                })
                ->when($request->age == '6', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6");
                })
                ->when($request->age == '7', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7");
                })
                ->when($request->age == '8', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8");
                })
                ->when($request->age == '9', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9");
                })
                ->when($request->age == 'total', function ($q) use ($request) {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9");
                })
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'adolescent', function ($q) use ($request) {
                $q->when($request->params == 'decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'missing', function ($q) use ($request) {
                    $q->where('tooth_condition', 'M');
                })
                ->when($request->params == 'filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19")
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'adult', function ($q) use ($request) {
                $q->when($request->params == 'decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'missing', function ($q) use ($request) {
                    $q->where('tooth_condition', 'M');
                })
                ->when($request->params == 'filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59")
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'senior', function ($q) use ($request) {
                $q->when($request->params == 'decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                    ->when($request->params == 'missing', function ($q) use ($request) {
                        $q->where('tooth_condition', 'M');
                    })
                    ->when($request->params == 'filled', function ($q) use ($request) {
                        $q->where('tooth_condition', 'F');
                    })
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60")
                    ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'total', function ($q) use ($request) {
                $q->when($request->params == 'decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'missing', function ($q) use ($request) {
                    $q->where('tooth_condition', 'M');
                })
                ->when($request->params == 'filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5")
                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)");
            })
            ->when($request->indicator == 'grand_total', function ($q) use ($request) {
                $q->when($request->params == 'decayed', function ($q) use ($request) {
                    $q->where('tooth_condition', 'D');
                })
                ->when($request->params == 'missing', function ($q) use ($request) {
                    $q->where('tooth_condition', 'M');
                })
                ->when($request->params == 'filled', function ($q) use ($request) {
                    $q->where('tooth_condition', 'F');
                })
            ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5");
            })
            ->whereIn('dental_tooth_conditions.tooth_number',
                [
                    '11', '12', '13', '14', '15',
                    '16', '17', '18', '21', '22',
                    '23', '24', '25', '26', '27',
                    '28', '41', '42', '43', '44',
                    '45', '46', '47', '48', '31',
                    '32', '33', '34', '35', '36',
                    '37', '38'
                ]
            )
            ->whereIn('patients.gender', explode(',', $request->gender))
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
/*            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })*/
            ->groupBy('patients.id');
    }

    public function get_dental_services($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service,
                        COUNT(patients.id) AS tooth_count
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_tooth_services', 'consults.id', '=', 'dental_tooth_services.consult_id')
            ->leftJoin('dental_services', 'consults.id', '=', 'dental_services.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consults.facility_code', auth()->user()->facility_code);
            })
            ->when($request->indicator == 'pregnant', function ($q) use ($request) {
                $q->where('consults.is_pregnant', 1)
                    ->when($request->age == '10-14', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14");
                    })
                    ->when($request->age == '15-19', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19");
                    })
                    ->when($request->age == '20-49', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49");
                    })
                    ->when($request->params == 'op_scaling', function ($q) use ($request) {
                        $q->whereIn('service_id', [19, 14]);
                    })
                    ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                        $q->where('service_code', 'PF');
                    })
                    ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                        $q->where('service_code', 'TF');
                    })
                    ->when($request->params == 'extraction', function ($q) use ($request) {
                        $q->where('service_code', 'X');
                    })
                    ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                        $q->where('service_id', 5);
                    })
                    ->when($request->params == 'post_operative', function ($q) use ($request) {
                        $q->where('service_id', 18);
                    })
                    ->when($request->params == 'abscess', function ($q) use ($request) {
                        $q->where('service_id', 3);
                    })
                    ->when($request->params == 'other_services', function ($q) use ($request) {
                        $q->where('service_id', 20);
                    })
                    ->when($request->params == 'referred', function ($q) use ($request) {
                        $q->where('service_id', 11);
                    })
                    ->when($request->params == 'counseling', function ($q) use ($request) {
                        $q->whereIn('service_id', [4, 8]);
                    });
            })
            ->when($request->indicator == 'infant', function ($q) use ($request) {
                $q->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11")
                    ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->params == 'op_scaling', function ($q) use ($request) {
                        $q->whereIn('service_id', [19, 14]);
                    })
                    ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                        $q->where('service_code', 'PF');
                    })
                    ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                        $q->where('service_code', 'TF');
                    })
                    ->when($request->params == 'extraction', function ($q) use ($request) {
                        $q->where('service_code', 'X');
                    })
                    ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                        $q->where('service_id', 5);
                    })
                    ->when($request->params == 'post_operative', function ($q) use ($request) {
                        $q->where('service_id', 18);
                    })
                    ->when($request->params == 'abscess', function ($q) use ($request) {
                        $q->where('service_id', 3);
                    })
                    ->when($request->params == 'other_services', function ($q) use ($request) {
                        $q->where('service_id', 20);
                    })
                    ->when($request->params == 'referred', function ($q) use ($request) {
                        $q->where('service_id', 11);
                    });
                })
                ->when($request->indicator == 'underfive', function ($q) use ($request) {
                    $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                        ->when($request->age == '1', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1");
                        })
                        ->when($request->age == '2', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2");
                        })
                        ->when($request->age == '3', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3");
                        })
                        ->when($request->age == '4', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4");
                        })
                        ->when($request->age == 'total', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4");
                        })
                        ->when($request->params == 'op_scaling', function ($q) use ($request) {
                            $q->whereIn('service_id', [19, 14]);
                        })
                        ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                            $q->where('service_code', 'PF');
                        })
                        ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                            $q->where('service_code', 'TF');
                        })
                        ->when($request->params == 'extraction', function ($q) use ($request) {
                            $q->where('service_code', 'X');
                        })
                        ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                            $q->where('service_id', 5);
                        })
                        ->when($request->params == 'flouride', function ($q) use ($request) {
                            $q->where('service_id', 17);
                        })
                        ->when($request->params == 'post_operative', function ($q) use ($request) {
                            $q->where('service_id', 18);
                        })
                        ->when($request->params == 'abscess', function ($q) use ($request) {
                            $q->where('service_id', 3);
                        })
                        ->when($request->params == 'other_services', function ($q) use ($request) {
                            $q->where('service_id', 20);
                        })
                        ->when($request->params == 'referred', function ($q) use ($request) {
                            $q->where('service_id', 11);
                        })
                        ->when($request->params == 'counseling', function ($q) use ($request) {
                            $q->whereIn('service_id', [4, 8]);
                        })
                        ->when($request->params == 'completed', function ($q) use ($request) {
                            $q->where('service_id', 15);
                        });
                })
                ->when($request->indicator == 'school_age', function ($q) use ($request) {
                    $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                        ->when($request->age == '5', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5");
                        })
                        ->when($request->age == '6', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6");
                        })
                        ->when($request->age == '7', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7");
                        })
                        ->when($request->age == '8', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8");
                        })
                        ->when($request->age == '9', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9");
                        })
                        ->when($request->age == 'total', function ($q) use ($request) {
                            $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9");
                        })
                        ->when($request->params == 'op_scaling', function ($q) use ($request) {
                            $q->whereIn('service_id', [19, 14]);
                        })
                        ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                            $q->where('service_code', 'PF');
                        })
                        ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                            $q->where('service_code', 'TF');
                        })
                        ->when($request->params == 'extraction', function ($q) use ($request) {
                            $q->where('service_code', 'X');
                        })
                        ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                            $q->where('service_id', 5);
                        })
                        ->when($request->params == 'sealant', function ($q) use ($request) {
                            $q->where('service_id', 10);
                        })
                        ->when($request->params == 'flouride', function ($q) use ($request) {
                            $q->where('service_id', 17);
                        })
                        ->when($request->params == 'post_operative', function ($q) use ($request) {
                            $q->where('service_id', 18);
                        })
                        ->when($request->params == 'abscess', function ($q) use ($request) {
                            $q->where('service_id', 3);
                        })
                        ->when($request->params == 'other_services', function ($q) use ($request) {
                            $q->where('service_id', 20);
                        })
                        ->when($request->params == 'referred', function ($q) use ($request) {
                            $q->where('service_id', 11);
                        })
                        ->when($request->params == 'counseling', function ($q) use ($request) {
                            $q->whereIn('service_id', [4, 8]);
                        })
                        ->when($request->params == 'completed', function ($q) use ($request) {
                            $q->where('service_id', 15);
                        });
                })
                ->when($request->indicator == 'adolescent', function ($q) use ($request) {
                    $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                        ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19")
                        ->when($request->params == 'op_scaling', function ($q) use ($request) {
                            $q->whereIn('service_id', [19, 14]);
                        })
                        ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                            $q->where('service_code', 'PF');
                        })
                        ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                            $q->where('service_code', 'TF');
                        })
                        ->when($request->params == 'extraction', function ($q) use ($request) {
                            $q->where('service_code', 'X');
                        })
                        ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                            $q->where('service_id', 5);
                        })
                        ->when($request->params == 'flouride', function ($q) use ($request) {
                            $q->where('service_id', 17);
                        })
                        ->when($request->params == 'post_operative', function ($q) use ($request) {
                            $q->where('service_id', 18);
                        })
                        ->when($request->params == 'abscess', function ($q) use ($request) {
                            $q->where('service_id', 3);
                        })
                        ->when($request->params == 'other_services', function ($q) use ($request) {
                            $q->where('service_id', 20);
                        })
                        ->when($request->params == 'referred', function ($q) use ($request) {
                            $q->where('service_id', 11);
                        })
                        ->when($request->params == 'counseling', function ($q) use ($request) {
                            $q->whereIn('service_id', [4, 8]);
                        });
                })
                ->when($request->indicator == 'adult', function ($q) use ($request) {
                    $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                        ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59")
                        ->when($request->params == 'op_scaling', function ($q) use ($request) {
                            $q->whereIn('service_id', [19, 14]);
                        })
                        ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                            $q->where('service_code', 'PF');
                        })
                        ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                            $q->where('service_code', 'TF');
                        })
                        ->when($request->params == 'extraction', function ($q) use ($request) {
                            $q->where('service_code', 'X');
                        })
                        ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                            $q->where('service_id', 5);
                        })
                        ->when($request->params == 'post_operative', function ($q) use ($request) {
                            $q->where('service_id', 18);
                        })
                        ->when($request->params == 'abscess', function ($q) use ($request) {
                            $q->where('service_id', 3);
                        })
                        ->when($request->params == 'other_services', function ($q) use ($request) {
                            $q->where('service_id', 20);
                        })
                        ->when($request->params == 'referred', function ($q) use ($request) {
                            $q->where('service_id', 11);
                        })
                        ->when($request->params == 'counseling', function ($q) use ($request) {
                            $q->whereIn('service_id', [4, 8]);
                        });
                    })
                    ->when($request->indicator == 'senior', function ($q) use ($request) {
                        $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                            ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60")
                            ->when($request->params == 'op_scaling', function ($q) use ($request) {
                                $q->whereIn('service_id', [19, 14]);
                            })
                            ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                                $q->where('service_code', 'PF');
                            })
                            ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                                $q->where('service_code', 'TF');
                            })
                            ->when($request->params == 'extraction', function ($q) use ($request) {
                                $q->where('service_code', 'X');
                            })
                            ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                                $q->where('service_id', 5);
                            })
                            ->when($request->params == 'post_operative', function ($q) use ($request) {
                                $q->where('service_id', 18);
                            })
                            ->when($request->params == 'abscess', function ($q) use ($request) {
                                $q->where('service_id', 3);
                            })
                            ->when($request->params == 'other_services', function ($q) use ($request) {
                                $q->where('service_id', 20);
                            })
                            ->when($request->params == 'referred', function ($q) use ($request) {
                                $q->where('service_id', 11);
                            })
                            ->when($request->params == 'counseling', function ($q) use ($request) {
                                $q->whereIn('service_id', [4, 8]);
                            });
                        })
                    ->when($request->indicator == 'all_age', function ($q) use ($request) {
                        $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                            ->when($request->params == 'op_scaling', function ($q) use ($request) {
                                $q->whereIn('service_id', [19, 14]);
                            })
                            ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                                $q->where('service_code', 'PF');
                            })
                            ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                                $q->where('service_code', 'TF');
                            })
                            ->when($request->params == 'extraction', function ($q) use ($request) {
                                $q->where('service_code', 'X');
                            })
                            ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                                $q->where('service_id', 5);
                            })
                            ->when($request->params == 'post_operative', function ($q) use ($request) {
                                $q->where('service_id', 18);
                            })
                            ->when($request->params == 'abscess', function ($q) use ($request) {
                                $q->where('service_id', 3);
                            })
                            ->when($request->params == 'other_services', function ($q) use ($request) {
                                $q->where('service_id', 20);
                            })
                            ->when($request->params == 'referred', function ($q) use ($request) {
                                $q->where('service_id', 11);
                            })
                            ->when($request->params == 'counseling', function ($q) use ($request) {
                                $q->whereIn('service_id', [4, 8]);
                            });
                })
                ->when($request->indicator == 'grand_total', function ($q) use ($request) {
                    $q->when($request->params == 'op_scaling', function ($q) use ($request) {
                            $q->whereIn('service_id', [19, 14]);
                        })
                        ->when($request->params == 'permanent_filling', function ($q) use ($request) {
                            $q->where('service_code', 'PF');
                        })
                        ->when($request->params == 'temporary_filling', function ($q) use ($request) {
                            $q->where('service_code', 'TF');
                        })
                        ->when($request->params == 'extraction', function ($q) use ($request) {
                            $q->where('service_code', 'X');
                        })
                        ->when($request->params == 'gum_treatment', function ($q) use ($request) {
                            $q->where('service_id', 5);
                        })
                        ->when($request->params == 'sealant', function ($q) use ($request) {
                            $q->where('service_id', 10)
                                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9");
                        })
                        ->when($request->params == 'flouride', function ($q) use ($request) {
                            $q->where('service_id', 10)
                                ->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 19");
                        })
                        ->when($request->params == 'post_operative', function ($q) use ($request) {
                            $q->where('service_id', 18);
                        })
                        ->when($request->params == 'abscess', function ($q) use ($request) {
                            $q->where('service_id', 3);
                        })
                        ->when($request->params == 'other_services', function ($q) use ($request) {
                            $q->where('service_id', 20);
                        })
                        ->when($request->params == 'referred', function ($q) use ($request) {
                            $q->where('service_id', 11);
                        })
                        ->when($request->params == 'counseling', function ($q) use ($request) {
                            $q->whereIn('service_id', [4, 8])
                                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 1");
                        })
                        ->when($request->params == 'completed', function ($q) use ($request) {
                            $q->where('service_id', 15)
                                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 3");
                        });
                })
                ->whereIn('patients.gender', explode(',', $request->gender))
                ->wherePtGroup('dn')
                ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
/*                ->when($request->category == 'fac', function ($q) {
                    $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
                })
                ->when($request->category == 'muncity', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
                })
                ->when($request->category == 'brgys', function ($q) use ($request) {
                    $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
                })*/
                ->groupBy('patients.id');
    }

    public function get_dental_ofc($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS date_of_service
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_medical_socials', 'dental_oral_health_conditions.patient_id', '=', 'dental_medical_socials.patient_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consults.facility_code', auth()->user()->facility_code);
            })
            ->when($request->indicator == 'underfive', function ($q) use ($request) {
                $q->whereRaw("(is_pregnant IS NULL OR is_pregnant = 0)")
                    ->when($request->age == '1', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1");
                    })
                    ->when($request->age == '2', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2");
                    })
                    ->when($request->age == '3', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3");
                    })
                    ->when($request->age == '4', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4");
                    })
                    ->when($request->age == 'total', function ($q) use ($request) {
                        $q->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4");
                    })
                    ->when($request->params == 'orally_fit', function ($q) use ($request) {
                        $q->where('orally_fit_flag', 1);
                    })
                    ->when($request->params == 'oral_rehab', function ($q) use ($request) {
                        $q->where('oral_rehab', 1);
                    });
            })
            ->whereIn('patients.gender', explode(',', $request->gender))
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->groupBy('patients.id');
    }
}
