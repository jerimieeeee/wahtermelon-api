<?php

namespace App\Http\Requests\API\V1\Adolescent;

use Illuminate\Foundation\Http\FormRequest;

class ConsultAsrhRapidRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'refer_to_user_id' => ['nullable', 'exists:users,id'],
            'referral_date' => ['required_with:refer_to_user_id', 'date', 'date_format:Y-m-d'],
            'assessment_date' => ['required', 'date', 'date_format:Y-m-d'],
            'client_type' => ['required', 'string', 'max:255'],
            'lib_asrh_client_type_code' => ['required_if:client_type,referred', 'exists:lib_asrh_client_types,code'],
            'other_client_type' => ['required_if:lib_asrh_client_type_code,99', 'string', 'max:255'],
            'consent_flag' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
            //'status' => ['nullable', 'in:done,refused'],
            'algorithm_remarks' => ['nullable', 'string'],
            'lib_asrh_living_arrangement_type_id' => ['required', 'exists:lib_asrh_living_arrangement_types,id'],
            'refused_flag' => ['nullable', 'boolean'],
            'lib_asrh_refusal_reason_id' => ['required_if:refused_flag,1', 'exists:lib_asrh_refusal_reasons,id'],
            'refusal_reason_other' => ['required_if:lib_asrh_refusal_reason_id,99', 'string'],
            'done_flag' => ['nullable', 'boolean'],
            'done_date' => ['required_if:done_flag,1', 'date', 'date_format:Y-m-d'],
        ];
    }
}
