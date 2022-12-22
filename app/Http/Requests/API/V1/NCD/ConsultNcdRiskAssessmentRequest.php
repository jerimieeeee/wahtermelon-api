<?php

namespace App\Http\Requests\API\V1\NCD;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibNcdAlcoholIntakeAnswer;
use App\Models\V1\Libraries\LibNcdAnswer;
use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibNcdClientType;
use App\Models\V1\Libraries\LibNcdLocation;
use App\Models\V1\Libraries\LibNcdSmokingAnswer;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ConsultNcdRiskAssessmentRequest extends FormRequest
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
        $age = $patient->birthdate->diff(request()->assessment_date)->y;
        return array_merge($this->validated(), [
            'age' => $age,
            'gender' => $gender,
        ]);
    }

    public function rules()
    {
        return [
            // 'patient_ncd_id' => 'required|exists:patient_ncd,id',
            'patient_id' => 'required|exists:patients,id',
            'consult_id' => 'required|exists:consults,id',
            'location' => 'required|exists:lib_ncd_locations,id',
            'client_type' => 'required|exists:lib_ncd_client_types,id',
            'assessment_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'family_hx_hypertension' => 'required|exists:lib_ncd_answers,id',
            'family_hx_stroke' => 'required|exists:lib_ncd_answers,id',
            'family_hx_heart_attack' => 'required|exists:lib_ncd_answers,id',
            'family_hx_diabetes' => 'required|exists:lib_ncd_answers,id',
            'family_hx_asthma' => 'required|exists:lib_ncd_answers,id',
            'family_hx_cancer' => 'required|exists:lib_ncd_answers,id',
            'family_hx_kidney_disease' => 'required|exists:lib_ncd_answers,id',
            'smoking' => 'required|exists:lib_ncd_smoking_answers,id',
            'alcohol_intake' => 'required|exists:lib_ncd_alcohol_intake_answers,id',
            'excessive_alcohol_intake' => 'required|exists:lib_ncd_answer_s2,id',
            'high_fat' => 'required|exists:lib_ncd_answer_s2,id',
            'intake_fruits' => 'required|exists:lib_ncd_answer_s2,id',
            'physical_activity' => 'required|exists:lib_ncd_answer_s2,id',
            'intake_vegetables' => 'required|exists:lib_ncd_answer_s2,id',
            'presence_diabetes' => 'required|exists:lib_ncd_answers,id',
            'diabetes_medications' => 'required|exists:lib_ncd_answers,id',
            'polyphagia' => 'required|exists:lib_ncd_answers,id',
            'polydipsia' => 'required|exists:lib_ncd_answers,id',
            'polyuria' => 'required|exists:lib_ncd_answers,id',
            'obesity' => 'boolean',
            'central_adiposity' => 'boolean',
            'bmi' => 'required|numeric',
            'waist_line' => 'required|numeric',
            'raised_bp' => 'boolean',
            'avg_systolic' => 'required|numeric',
            'avg_diastolic' => 'required|numeric',
            'systolic_1st' => 'required|numeric',
            'diastolic_1st' => 'required|numeric',
            'systolic_2nd' => 'required|numeric',
            'diastolic_2nd' => 'required|numeric',
            // 'gender' => 'required',
            // 'age' => 'required|numeric',
        ];
    }

    protected function prepareForValidation()
    {
         $this->merge([
            'date_enrolled' => $this->assessment_date,
            'patient_ncd_id' => $this->id
        ]);
    }

    public function bodyParameters()
    {
        $gender = fake()->randomElement(['M', 'F', 'I']);
        return [
            'patient_ncd_id' => [
                'description' => 'ID of patient_ncd',
                'example' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'consult_id' => [
                'description' => 'ID of consult',
                'example' => fake()->randomElement(Consult::pluck('id')->toArray()),
            ],
            'location' => [
                'description' => 'location of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdLocation::pluck('id')->toArray()),
            ],
            'client_type' => [
                'description' => 'client type of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdClientType::pluck('id')->toArray()),
            ],
            'assessment_date' => [
                'description' => 'assessment date of ncd risk assessment',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'family_hx_hypertension' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'family_hx_stroke' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'family_hx_heart_attack' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'family_hx_diabetes' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'family_hx_asthma' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'family_hx_cancer' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'family_hx_kidney_disease' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'family_hx_cancer' => [
                'description' => 'family history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'smoking' => [
                'description' => 'smoking history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdSmokingAnswer::pluck('id')->toArray()),
            ],
            'alcohol_intake' => [
                'description' => 'alcohol intake history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAlcoholIntakeAnswer::pluck('id')->toArray()),
            ],
            'high_fat' => [
                'description' => 'high fat history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'intake_fruits' => [
                'description' => 'intake fruit history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'physical_activity' => [
                'description' => 'physical activity history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'intake_vegetables' => [
                'description' => 'intake vegetable history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'presence_diabetes' => [
                'description' => 'presence of diabetes history of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswerS2::pluck('id')->toArray()),
            ],
            'diabetes_medications' => [
                'description' => 'diabetes medication of ncd risk assessment',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'polyphagia' => [
                'description' => 'is patient polyphagia?',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'polydipsia' => [
                'description' => 'is patient polydipsia?',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'polyyuria' => [
                'description' => 'is patient polyyuria?',
                'example' => fake()->randomElement(LibNcdAnswer::pluck('id')->toArray()),
            ],
            'obesity' => [
                'description' => 'is patient obese?',
                'example' => fake()->boolean(),
            ],
            'centra_adiposity' => [
                'description' => 'is patient central adiposity?',
                'example' => fake()->boolean(),
            ],
            'bmi' => [
                'description' => 'bmi of patient',
                'example' => fake()->randomFloat(),
            ],
            'waist_line' => [
                'description' => 'waistline of patient',
                'example' => fake()->randomFloat(),
            ],
            'raised_bp' => [
                'description' => 'is patient raised bp?',
                'example' => fake()->boolean(),
            ],
            'avg_systolic' => [
                'description' => 'avg systolic of patient',
                'example' => fake()->randomNumber(3, true),
            ],
            'avg_systolic' => [
                'description' => 'avg systolic of patient',
                'example' => fake()->randomNumber(3, true),
            ],
            'avg_diastolic' => [
                'description' => 'avg diastolic of patient',
                'example' => fake()->randomNumber(3, true),
            ],
            'systolic_1st' => [
                'description' => '1st systolic of patient',
                'example' => fake()->randomNumber(3, true),
            ],
            'diastolic_1st' => [
                'description' => '1st diastolic of patient',
                'example' => fake()->randomNumber(3, true),
            ],
            'systolic_2nd' => [
                'description' => '2nd systolic of patient',
                'example' => fake()->randomNumber(3, true),
            ],
            'diastolic_2nd' => [
                'description' => '2nd diastolic of patient',
                'example' => fake()->randomNumber(3, true),
            ],
            // 'gender' => [
            //     'description' => 'gender of the patient.',
            //     'example' => substr(Str::ucfirst($gender), 0, 1),
            // ],
            // 'age' => [
            //     'description' => 'age of the patient.',
            //     'example' => fake()->randomNumber(2, true),
            // ],
        ];

    }
}
