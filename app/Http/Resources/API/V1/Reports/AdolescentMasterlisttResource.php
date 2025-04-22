<?php

namespace App\Http\Resources\API\V1\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdolescentMasterlisttResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient_opd_id' => $this->patient->id,
            'initials' =>
                (isset($this->patient->last_name) ? strtoupper(substr($this->patient->last_name, 0, 1)) . '.' : '') .
                (isset($this->patient->first_name) ? ' ' . strtoupper(substr($this->patient->first_name, 0, 1)) . '.' : '') .
                (isset($this->patient->middle_name) ? ' ' . strtoupper(substr($this->patient->middle_name, 0, 1)) . '.' : ''),
            'age' => ! empty($this->patient->birthdate) ? Carbon::parse($this->patient->birthdate)->diff($this->assessment_date ?? '')->y.' Year(s), '.Carbon::parse($this->patient->birthdate)->diff($this->assessment_date ?? '')->m.' Month(s), '.Carbon::parse($this->patient->birthdate)->diff($this->assessment_date ?? '')->d.' Day(s)' : '',
            'gender' => $this->patient->gender,
            'gender_identity' => $this->patient->gender_identity->desc ?? null,
            'birthdate' => $this->patient->birthdate,
            'living_arrangement' => $this->living_arrangement_type->desc ?? null,
            'area_of_residence' => $this->patient->householdFolder->barangay->name,
            'mobile_number' => $this->patient->mobile_number,
            'mode_of_referral' => $this->client_type,
            'client_type' => $this->clientTypes->desc ?? null,
            'education' => $this->patient->education->education_desc,
            'occupation' => $this->patient->occupation->occupation_desc,
            'complaint' => $this->consult->consultNotes->complaints,
            'history_of_current_illness' => $this->consult->consultNotes->history,
            'alcohol_use' => isset($this->patient->socialHistory->alcohol) ? ($this->patient->socialHistory->alcohol === 'Y' ? 'YES' : 'NO') : null,
            'tobacco_vape_use' => isset($this->patient->socialHistory->smoking) ? ($this->patient->socialHistory->smoking === 'Y' ? 'YES' : 'NO') : null,
            'illicit_drug_use' => isset($this->patient->socialHistory->illicit_drugs) ? ($this->patient->socialHistory->illicit_drugs === 'Y' ? 'YES' : 'NO') : null,
            'self_harm' => isset($this->comprehensive->self_harm) ? ($this->comprehensive->self_harm ? 'YES' : 'NO') : null,
            'sexually_active' => isset($this->patient->socialHistory->sexually_active) ? ($this->patient->socialHistory->sexually_active === 'Y' ? 'YES' : 'NO') : null,
            'risky_behavior' => isset($this->patient->socialHistory->risky_behavior) ? ($this->patient->socialHistory->risky_behavior ? 'YES' : 'NO') : null,
            'with_family_planning' => isset($this->patient->pregnancyHistory->with_family_planning) ? ($this->patient->pregnancyHistory->with_family_planning === 'Y' ? 'YES' : 'NO') : null,
            'question3' => $this->answersQuestion3 ?? null,
            'abuse_history' => isset($this->answersQuestion3)
                ? ($this->answersQuestion3->answer === '1'
                    ? 'YES'
                    : (in_array(optional($this->consult->consultNotes->finaldx->first())->icd10_code, ['T74.1', 'T74.2', 'T74.3']) ? 'YES' : 'NO'))
                : 'NO',
            'menarche' => $this->patient->menstrualHistory->menarche ?? null,
            'interval_of_menses' => $this->patient->menstrualHistory->cycle ?? null,
            'lmp' => $this->patient->menstrualHistory->lmp ?? null,
            'age_of_gestation' => ! empty($this->patient->menstrualHistory->lmp)
                ? (function () {
                    $lmp = Carbon::parse($this->patient->menstrualHistory->lmp);
                    $assessmentDate = Carbon::parse($this->assessment_date ?? now());
                    $totalDays = $lmp->diffInDays($assessmentDate);
                    $weeks = intdiv($totalDays, 7);
                    $days = $totalDays % 7;
                    return "$weeks Week(s) and $days Day(s)";
                })()
                : '',
            'gravidity_parity' => $this->patient->pregnancyHistory ?? null,
            'height' => $this->vitalsAsrh->patient_height ?? null,
            'weight' => $this->vitalsAsrh->patient_weight ?? null,
            'bmi' => $this->vitalsAsrh->patient_bmi ?? null,
            'bmi_class' => $this->vitalsAsrh->patient_bmi_class ?? null,
            'blood_pressure' => isset($this->vitalsAsrh) && $this->vitalsAsrh->bp_systolic && $this->vitalsAsrh->bp_diastolic
                ? $this->vitalsAsrh->bp_systolic . '/' . $this->vitalsAsrh->bp_diastolic
                : null,
            'heart_rate' => $this->vitalsAsrh->patient_heart_rate ?? null,
            'physical_exam' => $this->consult->consultNotes->physicalExam ?? null,
            'diagnosis' => $this->consult->consultNotes->finaldx ?? null,
            'management' => $this->consult->consultNotes->plan ?? null,
        ];
    }
}
