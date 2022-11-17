<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVitals;
use App\Models\V1\PSGC\Facility;
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
        if($years > 6) {
            if(isset(request()->patient_height) && isset(request()->patient_weight)) {
                $height = request()->patient_height;
                $weight = request()->patient_weight;
            } else if(isset(request()->patient_height) && !isset(request()->patient_weight)) {
                $data = PatientVitals::select('patient_weight')
                        ->wherePatientId(request()->patient_id)
                        ->whereNotNull('patient_weight')
                        ->orderBy('vitals_date', 'DESC')
                        ->first();
                $height = request()->patient_height;
                $weight = $data ? $data->patient_weight : null;

            } else if(!isset(request()->patient_height) && isset(request()->patient_weight)) {
                $data = PatientVitals::select('patient_height')
                    ->wherePatientId(request()->patient_id)
                    ->whereNotNull('patient_height')
                    ->orderBy('vitals_date', 'DESC')
                    ->first();
                $height = $data ? $data->patient_height : null;
                $weight = request()->patient_weight;

            } else {
                $data = PatientVitals::select('patient_height', 'patient_weight')->addSelect([
                        'patient_height' => PatientVitals::select('patient_height')
                            ->whereColumn('patient_id', 'patient_vitals.patient_id')
                            ->whereNotNull('patient_height')
                            ->orderBy('vitals_date', 'DESC')->limit(1),
                        'patient_weight' => PatientVitals::select('patient_weight')
                            ->whereColumn('patient_id', 'patient_vitals.patient_id')
                            ->whereNotNull('patient_weight')
                            ->orderBy('vitals_date', 'DESC')->limit(1),
                    ])
                    ->wherePatientId(request()->patient_id)->havingRaw('patient_height IS NOT NULL AND patient_weight IS NOT NULL')
                    ->orderBy('vitals_date', 'DESC')
                    ->first();
                $height = $data ? $data->patient_height : null;
                $weight = $data ? $data->patient_weight : null;
            }
            if($weight != null && $height != null) {
                list($bmi, $bmiClass) = compute_bmi($weight, $height);
                //dd($bmiClass);
            }

            //dd($bmi);
        }
        return array_merge($this->validated(), [
            'patient_bmi' => ($height != null && $weight != null) ? $bmi : null,
            'patient_bmi_class' => ($height != null && $weight != null) ? $bmiClass : null,
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
            'facility_code' => 'required|exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
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
            'patient_waist' => 'nullable|numeric',
            'patient_hip' => 'nullable|numeric',
            'patient_limbs' => 'nullable|numeric',
            'patient_muac' => 'nullable|numeric',
        ];
    }

    public function bodyParameters()
    {
        return [
            'facility_code' => [
                'description' => 'ID of facility library',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
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
