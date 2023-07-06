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
            'incident_first_unknown' => 'nullable|boolean',
            'incident_first_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'incident_first_remarks' => 'nullable',
            'incident_recent_unknown' => 'nullable|boolean',
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

            'behavior_cooperative_flag' => 'nullable|boolean',
            'behavior_crying_flag' => 'nullable|boolean',
            'behavior_clinging_flag' => 'nullable|boolean',
            'behavior_responsive_flag' => 'nullable|boolean',
            'behavior_silent_flag' => 'nullable|boolean',
            'behavior_able_to_narrate_flag' => 'nullable|boolean',
            'behavior_unable_to_narrate_flag' => 'nullable|boolean',
            'behavior_appropriate_affect_flag' => 'nullable|boolean',
            'behavior_depressed_affect_flag' => 'nullable|boolean',
            'behavior_flat_affect_flag' => 'nullable|boolean',
            'behavior_psychotic_flag' => 'nullable|boolean',
            'behavior_combative_flag' => 'nullable|boolean',
            'behavior_hyperactive_flag' => 'nullable|boolean',
            'behavior_short_attention_flag' => 'nullable|boolean',

            'behavior_historian_cooperative_flag' => 'nullable|boolean',
            'behavior_historian_crying_flag' => 'nullable|boolean',
            'behavior_historian_clinging_flag' => 'nullable|boolean',
            'behavior_historian_responsive_flag' => 'nullable|boolean',
            'behavior_historian_silent_flag' => 'nullable|boolean',
            'behavior_historian_able_to_narrate_flag' => 'nullable|boolean',
            'behavior_historian_unable_to_narrate_flag' => 'nullable|boolean',
            'behavior_historian_appropriate_affect_flag' => 'nullable|boolean',
            'behavior_historian_depressed_affect_flag' => 'nullable|boolean',
            'behavior_historian_flat_affect_flag' => 'nullable|boolean',
            'behavior_historian_psychotic_flag' => 'nullable|boolean',
            'behavior_historian_combative_flag' => 'nullable|boolean',
            'behavior_historian_hyperactive_flag' => 'nullable|boolean',
            'behavior_historian_short_attention_flag' => 'nullable|boolean',

            'child_behavior_remarks' => 'nullable',
            'dev_screening_remarks' => 'nullable',
            'source_from_historian_flag' => 'nullable|boolean',
            'source_from_historian_remarks' => 'nullable',
            'source_from_sworn_statement_flag' => 'nullable|boolean',
            'source_from_victim_flag' => 'nullable|boolean',
            'mental_age_id' => 'nullable',
            'child_caretaker_present_flag' => 'nullable|boolean',
            'dev_screening_id' => 'nullable',
            'disclosed_relation_id' => 'nullable',
            'other_abuse_acts' => 'nullable',
            'deferred' => 'nullable|boolean',
            'deferral_datetime' => 'nullable|date|date_format:Y-m-d H:i:s|before:tomorrow',
            'deferral_reason_id' => 'nullable',
            'deferral_previous_interviewer_id' => 'nullable',
            'deferral_interviewer_remarks' => 'nullable',
        ];
    }
}
