<?php

namespace App\Http\Requests\API\V1\NCD;

use App\Models\V1\Libraries\LibNcdRiskScreeningUrineKetones;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultNcdRiskScreeningUrineKetonesRequest extends FormRequest
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
            'consult_ncd_risk_id' => 'required|exists:consult_ncd_risk_assessment,id',
            'patient_ncd_id' => 'required|exists:patient_ncd,id',
            'patient_id' => 'required|exists:patients,id',
            'date_taken' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'ketone' => 'required|exists:lib_ncd_risk_screening_urine_ketones,id',
            'presence_of_urine_ketone' => 'boolean',
        ];
    }

    public function bodyParameters()
    {
        return [
            'consult_ncd_risk_id' => [
                'description' => 'ID of ncd risk assessment',
                'example' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            ],
            'patient_ncd_id' => [
                'description' => 'ID of patient ncd',
                'example' => fake()->randomElement(PatientNcd::pluck('id')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'date_taken' => [
                'description' => 'Date taken',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'ketone' => [
                'description' => 'ketones of patient',
                'example' => fake()->randomElement(LibNcdRiskScreeningUrineKetones::pluck('id')->toArray()),
            ],
            'presence_of_urine_ketone' => [
                'description' => 'is there a presence urine ketones?',
                'example' => fake()->boolean(),
            ],
        ];
    }
}
