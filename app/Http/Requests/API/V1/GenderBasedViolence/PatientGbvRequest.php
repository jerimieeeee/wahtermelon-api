<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use App\Models\V1\Libraries\LibGbvOutcomeReason;
use App\Models\V1\Libraries\LibGbvOutcomeResult;
use App\Models\V1\Libraries\LibGbvOutcomeVerdict;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientGbvRequest extends FormRequest
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
            'id' => 'nullable',
            'patient_id' => 'required|exists:patients,id',
            'outcome_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'gbv_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'gbv_complaint_remarks' => 'nullable',
            'gbv_behavioral_remarks' => 'nullable',
            'gbv_neglect_remarks' => 'nullable',
            'outcome_reason_id' => 'nullable|exists:lib_gbv_outcome_reasons,id',
            'outcome_result_id' => 'nullable|exists:lib_gbv_outcome_results,id',
            'outcome_verdict_id' => 'nullable|exists:lib_gbv_outcome_verdicts,id',
            'complaint' => 'nullable|array',
            'complaint.*.complaint_id' => 'nullable|exists:lib_complaints,complaint_id',
            'behavior' => 'nullable|array',
            'behavior.*.behavioral_id' => 'nullable|exists:lib_gbv_behaviorals,id',
            'neglect' => 'nullable|array',
            'neglect.*.neglect_id' => 'nullable|exists:lib_gbv_neglects,id',
            'referral_facility_code' => 'nullable|exists:facilities,code',
            'referral_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'referral_reason' => 'nullable',
            'service_remarks' => 'nullable',
            'referral_remarks' => 'nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'patient_gbv_id' => $this->id,
        ]);
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'outcome_date' => [
                'description' => 'Outcome date of Patient GBV',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'outcome_reason_id' => [
                'description' => 'Treatment outcome of patient from library',
                'example' => fake()->randomElement(LibGbvOutcomeReason::pluck('id')->toArray()),
            ],
            'outcome_result_id' => [
                'description' => 'Outcome reason for died and stop tb treatent from library',
                'example' => fake()->randomElement(LibGbvOutcomeResult::pluck('id')->toArray()),
            ],
            'outcome_verdict_id' => [
                'description' => 'Outcome reason for died and stop tb treatent from library',
                'example' => fake()->randomElement(LibGbvOutcomeVerdict::pluck('id')->toArray()),
            ],
        ];
    }
}
