<?php

namespace App\Http\Requests\API\V1\NCD;

use App\Models\V1\Libraries\LibNcdPhysicalExamAnswer;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Database\Seeders\LibNcdPhysicalExamAnswerSeeder;
use Illuminate\Foundation\Http\FormRequest;

class PatientNcdRecordRequest extends FormRequest
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
    public function rules()
    {
        return [
            'patient_ncd_id' => 'required|exists:patient_ncd,id',
            'consult_ncd_risk_id' => 'required|exists:consult_ncd_risk_assessment,id',
            'patient_id' => 'required|exists:patients,id',
            'consultation_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'current_medications' => 'nullable',
            'palpitation_heart' => 'required|exists:lib_ncd_physical_exam_answers,id',
            'peripheral_pulses' => 'required|exists:lib_ncd_physical_exam_answers,id',
            'abdomen' => 'required|exists:lib_ncd_physical_exam_answers,id',
            'heart' => 'required|exists:lib_ncd_physical_exam_answers,id',
            'lungs' => 'required|exists:lib_ncd_physical_exam_answers,id',
            'sensation_feet' => 'required|exists:lib_ncd_physical_exam_answers,id',
            'other_findings' => 'nullable',
            'other_infos' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_ncd_id' => [
                'description' => 'ID of patient ncd',
                'example' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            ],
            'consult_ncd_risk_id' => [
                'description' => 'ID of consult ncd risk assessment',
                'example' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'consultation_date' => [
                'description' => 'Date of consultation',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'current_medications' => [
                'description' => 'remarks of current medications',
                'example' => fake()->sentence(),
            ],
            'palpitation_heart' => [
                'description' => 'is normal or abnormal?',
                'example' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            ],
            'peripheral_pulses' => [
                'description' => 'is normal or abnormal?',
                'example' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            ],
            'abdomen' => [
                'description' => 'is normal or abnormal?',
                'example' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            ],
            'heart' => [
                'description' => 'is normal or abnormal?',
                'example' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            ],
            'lungs' => [
                'description' => 'is normal or abnormal?',
                'example' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            ],
            'sensation_feet' => [
                'description' => 'is normal or abnormal?',
                'example' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            ],
            'palpitation_heart' => [
                'description' => 'is normal or abnormal?',
                'example' => fake()->randomElement(LibNcdPhysicalExamAnswer::pluck('id')->toArray()),
            ],
            'other_findings' => [
                'description' => 'remarks of other findings',
                'example' => fake()->sentence(),
            ],
            'other_infos' => [
                'description' => 'remarks of other infos',
                'example' => fake()->sentence(),
            ],
        ];
    }
}
