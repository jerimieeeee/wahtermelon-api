<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVitals;
use App\Models\V1\PSGC\Facility;
use App\Services\Patient\PatientVitalsService;
use Illuminate\Foundation\Http\FormRequest;

class PatientVitalsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function validatedWithCasts(): array
    {
        $patient = Patient::find(request()->patient_id);
        $gender = $patient->gender;
        $years = $patient->birthdate->diffInYears(request()->vitals_date);
        $months = $patient->birthdate->diffInMonths(request()->vitals_date);
        $patientVitals = new PatientVitalsService();
        if($years > 6) {
            list($weight, $height, $bmi, $bmiClass) = $patientVitals->get_patient_bmi();
        } else{
            $height = "";
            $weight = "";
        }
        if($months < 72) {
            $weightForAge = "";
            $heightForAge = "";
            $weightForHeight = "";
            if(isset(request()->patient_weight)) {
                $weightForAge = $patientVitals->get_weight_for_age($months, $gender, request()->patient_weight);
                $weightForAgeClass = $weightForAge ? $weightForAge->wt_class : null;
            }
            if(isset(request()->patient_height)) {
                $heightForAge = $patientVitals->get_height_for_age($months, $gender, request()->patient_height);
                $heightForAgeClass = $heightForAge ? $heightForAge->lt_class : null;
            }
            if(isset(request()->patient_weight) && isset(request()->patient_height)) {
                $weightForHeight = $patientVitals->get_weight_for_height($months, $gender, request()->patient_weight, request()->patient_height);
                $weightForHeightClass = $weightForHeight ? $weightForHeight->wt_class : null;
            }

        } else {
            $weightForAge = "";
            $heightForAge = "";
            $weightForHeight = "";
        }

        return array_merge($this->validated(), [
            'patient_bmi' => ($height != null && $weight != null) ? $bmi : null,
            'patient_bmi_class' => ($height != null && $weight != null) ? $bmiClass : null,
            'patient_weight_for_age' => $weightForAge != null ? $weightForAgeClass : null,
            'patient_height_for_age' => $heightForAge != null ? $heightForAgeClass : null,
            'patient_weight_for_height' => $weightForHeight != null ? $weightForHeightClass : null,
            'patient_age_years' => $years,
            'patient_age_months' => $months
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //'facility_code' => 'required|exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            //'user_id' => 'required|exists:users,id',
            'vitals_date' => 'date|date_format:Y-m-d H:i:s|before:tomorrow|required',
            'patient_temp' => 'nullable|numeric',
            'patient_height' => 'nullable|numeric',
            'patient_weight' => 'nullable|numeric',
            'patient_head_circumference' => 'nullable|numeric',
            'patient_skinfold_thickness' => 'nullable|numeric',
            'bp_systolic' => 'required_with:bp_diastolic|numeric|nullable',
            'bp_diastolic' => 'required_with:bp_systolic|numeric|nullable',
            'patient_heart_rate' => 'nullable|numeric',
            'patient_respiratory_rate' => 'nullable|numeric',
            'patient_pulse_rate' => 'nullable|numeric',
            'patient_spo2' => 'nullable|numeric',
            'patient_chest' => 'nullable|numeric',
            'patient_abdomen' => 'nullable|numeric',
            'patient_waist' => 'nullable|numeric',
            'patient_hip' => 'nullable|numeric',
            'patient_limbs' => 'nullable|numeric',
            'patient_muac' => 'nullable|numeric',
        ];
    }

    public function bodyParameters()
    {
        return [
            /* 'facility_code' => [
                'description' => 'ID of facility library',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ], */
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            /* 'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ], */
            'vitals_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s')
            ],
            'patient_temp' => [
                'example' => fake()->numberBetween(35, 40)
            ],
            'patient_height' => [
                'example' => fake()->numberBetween(100, 200)
            ],
            'patient_weight' => [
                'example' => fake()->numberBetween(40, 200)
            ],
            'patient_head_circumference' => [
                'example' => fake()->numberBetween(0, 30)
            ],
            'patient_skinfold_thickness' => [
                'example' => fake()->numberBetween(0, 30)
            ],
            'bp_systolic' => [
                'example' => fake()->numberBetween(100, 200)
            ],
            'bp_diastolic' => [
                'example' => fake()->numberBetween(70, 100)
            ],
            'patient_heart_rate' => [
                'example' => fake()->numberBetween(60, 100)
            ],
            'patient_respiratory_rate' => [
                'example' => fake()->numberBetween(12, 60)
            ],
            'patient_pulse_rate' => [
                'example' => fake()->numberBetween(60, 100)
            ],
            'patient_spo2' => [
                'example' => fake()->numberBetween(60, 100)
            ],
            'patient_chest' => [
                'example' => fake()->numberBetween(24, 150)
            ],
            'patient_abdomen' => [
                'example' => fake()->numberBetween(24, 150)
            ],
            'patient_waist' => [
                'example' => fake()->numberBetween(24, 150)
            ],
            'patient_hip' => [
                'example' => fake()->numberBetween(24, 150)
            ],
            'patient_limbs' => [
                'example' => fake()->numberBetween(60, 100)
            ],
            'patient_muac' => [
                'example' => fake()->numberBetween(60, 100)
            ],
        ];
    }
}
