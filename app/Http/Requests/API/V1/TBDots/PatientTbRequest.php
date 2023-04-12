<?php

namespace App\Http\Requests\API\V1\TBDots;

use App\Models\V1\Libraries\LibTbOutcomeReason;
use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientTbRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'tb_treatment_outcome_code' => 'exists:lib_tb_treatment_outcomes,code',
            'lib_tb_outcome_reason_id' => 'exists:lib_tb_outcome_reasons,id',
            'outcome_reason' => 'nullable',
            'outcome_date' => 'date|date_format:Y-m-d|before:tomorrow',
            'treatment_done' => 'boolean',
            'outcome_remarks' => 'nullable',
            'patient_tb_id' => 'exists:patient_tbs,id',
            'source_code' => 'required|exists:lib_tb_patient_sources,code',
            'reg_group_code' => 'required|exists:lib_tb_reg_groups,code',
            'previous_tb_treatment_code' => 'required|exists:lib_tb_previous_tb_treatments,code',
            'exposetb_flag' => 'boolean',
            'drtb_flag' => 'boolean',
            'risk_factor1' => 'boolean',
            'risk_factor2' => 'boolean',
            'risk_factor3' => 'boolean',
            'consult_date' => 'required|date|date_format:Y-m-d|before:tomorrow'
        ];
    }

    public function messages()
    {
        return [
            'outcome_date.before' => 'Outcome date must not be a future date.'
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray())
            ],
            'tb_treatment_outcome_code' => [
                'description' => 'Treatment outcome of patient from library',
                'example' => fake()->randomElement(LibTbTreatmentOutcome::pluck('code')->toArray())
            ],
            'lib_tb_outcome_reason_id' => [
                'description' => 'Outcome reason for died and stop tb treatent from library',
                'example' => fake()->randomElement(LibTbOutcomeReason::pluck('id')->toArray())
            ],
            'outcome_date' => [
                'description' => 'Outcome date of TB Treatment',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now')
            ],
            'treatment_done' => [
                'description' => 'Treatment status of TB Enrollment',
                'example' => fake()->boolean()
            ],
            'outcome_remarks' => [
                'description' => 'Treatment outcome remarks',
                'example' => fake()->sentence()
            ],
        ];
    }
}
