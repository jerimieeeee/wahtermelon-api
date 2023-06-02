<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvInterviewRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'patient_gbv_intake_id' => 'required|exists:patient_gbv_intakes,id',
            'interview_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'recant_flag' => 'nullable|boolean',
            'recant_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'recant_remarks' => 'nullable',
            'info_source_code' => 'nullable|exists:lib_answer_yn,code',
            'incident_first_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'incident_first_remarks' => 'nullable',
            'incident_recent_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'incident_recent_remarks' => 'nullable',
            'disclosed_flag' => 'nullable|exists:lib_answer_ynx,code',
            'disclosed_type' => 'nullable|exists:lib_gbv_disclosed_types,id',
            'abused_episode_id' => 'nullable|exists:lib_gbv_abused_episodes,id',
            'abused_episode_count' => 'nullable|numeric',
            'abused_site_id' => 'nullable|exists:lib_gbv_abused_sites,id',
            'abused_site_remarks' => 'nullable',
            'abused_site_remarks_address' => 'nullable',
            'initial_disclosure' => 'nullable',
            'witnessed_flag' => 'nullable|boolean',
            'relation_to_child' => 'nullable|exists:lib_gbv_child_relations,id',
            'child_behavior_id' => 'nullable|exists:lib_gbv_child_behaviors,id',
            'child_behavior_remarks' => 'nullable',
            'dev_screening_remarks' => 'nullable',
            'source_from_historian_flag' => 'nullable|boolean',
            'source_from_sworn_statement_flag' => 'nullable|boolean',
            'source_from_victim_flag' => 'nullable|boolean',
            'mental_age_id' => 'nullable',
            'child_caretaker_present_flag' => 'nullable|boolean',
            'dev_screening_id' => 'nullable',
            'disclosed_relation_id' => 'nullable',
            'deferred' => 'nullable|boolean',
            'deferral_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'deferral_reason_id' => 'nullable',
            'deferral_previous_interviewer_id' => 'nullable',
            'deferral_interviewer_remarks' => 'nullable'
        ];
    }
}
