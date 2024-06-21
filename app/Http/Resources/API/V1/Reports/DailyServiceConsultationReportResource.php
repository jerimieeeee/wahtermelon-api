<?php

namespace App\Http\Resources\API\V1\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyServiceConsultationReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'consult_id' => $this->id,
            'patient_id' => $this->patient->id,
            'patient_name' => ($this->patient->last_name ?? '') . ', ' . ($this->patient->first_name ?? '') . ' ' . ($this->patient->middle_name ?? ''),
            'user_name' => ($this->user->last_name ?? '') . ', ' . ($this->user->first_name ?? '') . ' ' . ($this->user->middle_name ?? ''),
            'gender' => $this->patient->gender ?? null,
            'birthdate' => $this->patient->birthdate ? Carbon::parse($this->patient->birthdate)->format('m/d/Y') : null,
            'age' => ! empty($this->patient->birthdate) ? Carbon::parse($this->patient->birthdate)->diff($this->consult_date ?? '')->y.' Year(s), '.Carbon::parse($this->patient->birthdate)->diff($this->consult_date ?? '')->m.' Month(s), '.Carbon::parse($this->patient->birthdate)->diff($this->consult_date ?? '')->d.' Day(s)' : '',
            'consult_date' => $this->consult_date ? Carbon::parse($this->consult_date)->format('m/d/Y') : null,
            'address' => ($this->patient->householdFolder->address ?? '') . ', ' . ($this->patient->householdFolder->barangay->name ?? ''),
            'is_konsulta' => $this->is_konsulta ?? null,
            'consent_flag' => $this->patient->consent_flag ?? null,
            'philhealth_id' => $this->philhealthLatest->philhealth_id ?? null,
            'vitals_date' => $this->vitalsLatest ? Carbon::parse($this->vitalsLatest->vitals_date)->format('m/d/Y') : null,
            'bp_systolic' => $this->vitalsLatest->bp_systolic ?? null,
            'bp_diastolic' => $this->vitalsLatest->bp_diastolic ?? null,
            'patient_temp' => $this->vitalsLatest->patient_temp ?? null,
            'patient_weight' => $this->vitalsLatest->patient_weight ?? null,
            'patient_height' => $this->vitalsLatest->patient_height ?? null,
            'patient_pulse_rate' => $this->vitalsLatest->patient_pulse_rate ?? null,
            'patient_heart_rate' => $this->vitalsLatest->patient_heart_rate ?? null,
            'patient_respiratory_rate' => $this->vitalsLatest->patient_respiratory_rate ?? null,
            'patient_bmi' => $this->vitalsLatest->patient_bmi ?? null,
            'patient_bmi_class' => $this->vitalsLatest->patient_bmi_class ?? null,
            'patient_waist' => $this->vitalsLatest->patient_waist ?? null,
            'patient_hip' => $this->vitalsLatest->patient_hip ?? null,
            'complaints' => $this->consultNotes->complaints ?? null,
            'complaint_remarks' => $this->consultNotes->complaint ?? null,
            'history' => $this->consultNotes->history ?? null,
            'initial_diagnosis' => $this->consultNotes->initialdx ?? null,
            'initial_dx_remarks' => $this->consultNotes->idx_remarks ?? null,
            'final_diagnosis' => $this->consultNotes->finaldx ?? null,
            'final_dx_remarks' => $this->consultNotes->fdx_remarks ?? null,
            'treatment_notes' => $this->consultNotes->plan ?? null,
            'prescription' => $this->prescription ?? null,
            'pe_remarks' => $this->consultNotes->physicalExamRemarks ?? null,
        ];
    }
}
