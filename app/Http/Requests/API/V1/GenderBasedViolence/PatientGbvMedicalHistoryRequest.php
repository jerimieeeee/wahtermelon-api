<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvMedicalHistoryRequest extends FormRequest
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
            'patient_temp' => 'nullable|numeric',
            'patient_heart_rate' => 'nullable|numeric',
            'patient_weight' => 'nullable|numeric',
            'patient_height' => 'nullable|numeric',
            'taking_medication_flag' => 'nullable|boolean',
            'taking_medication_remarks' => 'nullable',
            'general_survey_normal' => 'nullable|boolean',
            'general_survey_abnormal' => 'nullable|boolean',
            'general_survey_stunting' => 'nullable|boolean',
            'general_survey_wasting' => 'nullable|boolean',
            'general_survey_dirty_unkempt' => 'nullable|boolean',
            'general_survey_stuporous' => 'nullable|boolean',
            'general_survey_pale' => 'nullable|boolean',
            'general_survey_non_ambulant' => 'nullable|boolean',
            'general_survey_drowsy' => 'nullable|boolean',
            'general_survey_respiratory' => 'nullable|boolean',
            'general_survey_others' => 'nullable|boolean',
            'gbv_general_survey_remarks' => 'nullable',
            'menarche_flag' => 'nullable|boolean',
            'menarche_age' => 'nullable',
            'menarche_remarks' => 'nullable',
            'lmp_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'genital_discharge_uti_flag' => 'nullable|boolean',
            'past_hospitalizations_flag' => 'nullable|boolean',
            'past_hospital_remarks' => 'nullable',
            'scar_physical_abuse_flag' => 'nullable|boolean',
            'pertinent_med_history_flag' => 'nullable|boolean',
            'medical_history_remarks' => 'nullable',
            'summary_non_abuse_findings' => 'nullable',
        ];
    }
}
