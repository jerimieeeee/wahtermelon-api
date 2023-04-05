<?php

namespace App\Http\Requests\API\V1\TBDots;

use App\Models\V1\Libraries\LibTbPatientSource;
use App\Models\V1\Libraries\LibTbPreviousTbTreatment;
use App\Models\V1\Libraries\LibTbRegGroup;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientTbCaseFindingRequest extends FormRequest
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
            'consult_date.before' => 'The consult date must not be future date.',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray())
            ],
            'source_code' => [
                'description' => 'Code of patient source library',
                'example' => fake()->randomElement(LibTbPatientSource::pluck('code')->toArray())
            ],
            'reg_group_code' => [
                'description' => 'Code of registration group from library',
                'example' => fake()->randomElement(LibTbRegGroup::pluck('code')->toArray())
            ],
            'previous_tb_treatment_code' => [
                'description' => 'Code of previous tb treatment from library',
                'example' => fake()->randomElement(LibTbPreviousTbTreatment::pluck('code')->toArray())
            ],
            'exposetb_flag' => [
                'description' => 'Value of exposure to TB',
                'example' => fake()->boolean()
            ],
            'drtb_flag' => [
                'description' => 'Value if DRTB patient',
                'example' => fake()->boolean()
            ],
            'risk_factor1' => [
                'description' => 'Value of risk factor 1',
                'example' => fake()->boolean()
            ],
            'risk_factor2' => [
                'description' => 'Value of risk factor 2',
                'example' => fake()->boolean()
            ],
            'risk_factor3' => [
                'description' => 'Value of risk factor 3',
                'example' => fake()->boolean()
            ],
            'consult_date' => [
                'description' => 'Value of TB First Visit',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now')
            ],
        ];
    }
}
