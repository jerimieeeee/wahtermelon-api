<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvMedicalHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_gbv_intake_id' => $this->when(! $this->relationLoaded('patientGbv'), $this->patient_gbv_intake_id),
            'patientGbvIntake' => $this->whenLoaded('patientGbvIntake'),
            'patient_temp' => $this->patient_temp,
            'patient_heart_rate' => $this->patient_heart_rate,
            'patient_resp_rate' => $this->patient_resp_rate,
            'patient_weight' => $this->patient_weight,
            'patient_height' => $this->patient_height,
            'taking_medication_flag' => $this->taking_medication_flag,
            'taking_medication_remarks' => $this->taking_medication_remarks,
            'general_survey_normal' => $this->general_survey_normal,
            'general_survey_abnormal' => $this->general_survey_abnormal,
            'general_survey_stunting' => $this->general_survey_stunting,
            'general_survey_wasting' => $this->general_survey_wasting,
            'general_survey_dirty_unkempt' => $this->general_survey_dirty_unkempt,
            'general_survey_stuporous' => $this->general_survey_stuporous,
            'general_survey_pale' => $this->general_survey_pale,
            'general_survey_non_ambulant' => $this->general_survey_non_ambulant,
            'general_survey_drowsy' => $this->general_survey_drowsy,
            'general_survey_respiratory' => $this->general_survey_respiratory,
            'general_survey_others' => $this->general_survey_others,
            'gbv_general_survey_remarks' => $this->gbv_general_survey_remarks,

            'pe_head_and_neck_remarks' => $this->pe_head_and_neck_remarks,
            'pe_chest_and_lungs_remarks' => $this->pe_chest_and_lungs_remarks,
            'pe_breast_remarks' => $this->pe_breast_remarks,
            'pe_abdomen_remarks' => $this->pe_abdomen_remarks,
            'pe_back_remarks' => $this->pe_back_remarks,
            'pe_extremities_remarks' => $this->pe_extremities_remarks,
            'pe_anogenital_remarks' => $this->pe_anogenital_remarks,
            'pe_external_genitalia_remarks' => $this->pe_external_genitalia_remarks,
            'pe_anus_remarks' => $this->pe_anus_remarks,
            'pe_hymen_remarks' => $this->pe_hymen_remarks,
            'medical_impression_id' => $this->medical_impression_id,
            'medicalImpression' => $this->whenLoaded('medicalImpression'),
            'medical_impression_remarks' => $this->medical_impression_remarks,

            'menarche_flag' => $this->menarche_flag,
            'menarche_remarks' => $this->menarche_remarks,
            'lmp_date' => $this->lmp_date,
            'genital_discharge_uti_flag' => $this->genital_discharge_uti_flag,
            'past_hospitalizations_flag' => $this->past_hospitalizations_flag,
            'past_hospital_remarks' => $this->past_hospital_remarks,
            'scar_physical_abuse_flag' => $this->scar_physical_abuse_flag,
            'pertinent_med_history_flag' => $this->pertinent_med_history_flag,
            'medical_history_remarks' => $this->medical_history_remarks,
            'summary_non_abuse_findings' => $this->summary_non_abuse_findings,
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];

    }
}
