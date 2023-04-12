<?php

namespace App\Http\Requests\API\V1\TBDots;

use App\Models\V1\Libraries\LibTbAnatomicalSite;
use App\Models\V1\Libraries\LibTbBacteriologicalStatus;
use App\Models\V1\Libraries\LibTbEnrollAs;
use App\Models\V1\Libraries\LibTbEptbSite;
use App\Models\V1\Libraries\LibTbIptType;
use App\Models\V1\Libraries\LibTbTreatmentRegimen;
use App\Models\V1\Patient\Patient;
use App\Models\V1\TBDots\PatientTb;
use Illuminate\Foundation\Http\FormRequest;

class PatientTbCaseHoldingRequest extends FormRequest
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
            'patient_tb_id' => 'required|exists:patient_tbs,id',
            'enroll_as_code' => 'required|exists:lib_tb_enroll_as,code',
            'treatment_regimen_code' => 'required|exists:lib_tb_treatment_regimens,code',
            'registration_date' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'treatment_start' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'continuation_start' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'treatment_end' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'bacteriological_status_code' => 'nullable|exists:lib_tb_bacteriological_statuses,code',
            'anatomical_site_code' => 'nullable|exists:lib_tb_anatomical_sites,code',
            'eptb_site_id' => 'nullable|exists:lib_tb_eptb_sites,id',
            'specific_site' => 'nullable',
            'drug_resistant_flag' => 'boolean',
            'ipt_type_code' => 'nullable|exists:lib_tb_ipt_types,code',
            'transfer_flag' => 'boolean',
            'pict_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow'
        ];
    }

    public function messages()
    {
        return [
            'registration_date.before' => 'The registration date must not be future date.',
            'treatment_start.before' => 'The treatment start date must not be future date.',
            'continuation_start.before' => 'The continuation start date must not be future date.',
            'treatment_end.before' => 'The treatment end date must not be future date.',
            'pict_date.before' => 'The pict date must not be future date.',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray())
            ],
            'patient_tb_id' => [
                'description' => 'ID of patient tb',
                'example' => fake()->randomElement(PatientTb::pluck('id')->toArray())
            ],
            'enroll_as_code' => [
                'description' => 'Enrollment code from library',
                'example' => fake()->randomElement(LibTbEnrollAs::pluck('code')->toArray())
            ],
            'treatment_regimen_code' => [
                'description' => 'Treatment regimen code from library',
                'example' => fake()->randomElement(LibTbTreatmentRegimen::pluck('code')->toArray())
            ],
            'registration_date' => [
                'description' => 'Enrollment date',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now')
            ],
            'treatment_start' => [
                'description' => 'Treatment start date',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now')
            ],
            'continuation_start' => [
                'description' => 'Continuation start date',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now')
            ],
            'treatment_end' => [
                'description' => 'Treatment end date',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now')
            ],
            'bacteriological_status_code' => [
                'description' => 'Bacteriological status code from library',
                'example' => fake()->randomElement(LibTbBacteriologicalStatus::pluck('code')->toArray())
            ],
            'anatomical_site_code' => [
                'description' => 'Anatomical site code from library',
                'example' => fake()->randomElement(LibTbAnatomicalSite::pluck('code')->toArray())
            ],
            'eptb_site_id' => [
                'description' => 'EPTB site id from library',
                'example' => fake()->randomElement(LibTbEptbSite::pluck('id')->toArray())
            ],
            'specific_site' => [
                'description' => 'Site remarks',
                'example' => fake()->sentence()
            ],
            'drug_resistant_flag' => [
                'description' => 'Drug resitant flag',
                'example' => fake()->boolean()
            ],
            'ipt_type_code' => [
                'description' => 'IPT Type code from library',
                'example' => fake()->randomElement(LibTbIptType::pluck('code')->toArray())
            ],
            'transfer_flag' => [
                'description' => 'ID of patient',
                'example' => fake()->boolean()
            ],
            'pict_date' => [
                'description' => 'ID of patient',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now')
            ]
        ];
    }
}
