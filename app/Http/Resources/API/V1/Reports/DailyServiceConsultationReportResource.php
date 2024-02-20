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
            'gender' => $this->patient->gender ?? null,
            'birthdate' => $this->patient->birthdate ? Carbon::parse($this->patient->birthdate)->format('Y-m-d') : null,
            'age' => ! empty($this->patient->birthdate) ? Carbon::parse($this->birthdate)->diff($this->consult_date ?? '')->y.' Year(s), '.Carbon::parse($this->patient->birthdate)->diff($this->consult_date ?? '')->m.' Month(s), '.Carbon::parse($this->patient->birthdate)->diff($this->consult_date ?? '')->d.' Day(s)' : '',
            'consent_flag' => $this->patient->consent_flag ?? null,
            'consult_date' => $this->consult_date ? Carbon::parse($this->consult_date)->format('Y-m-d') : null,
            'address' => ($this->patient->householdFolder->address ?? null) . ', ' . ($this->patient->householdFolder->barangay->name ?? null),
            'philhealth_id' => $this->philhealthLatest->philhealth_id ?? null,
            'is_konsulta' => $this->is_konsulta ?? null,
            'bp_systolic' => $this->vitalsLatest->bp_systolic ?? null,
            'bp_diastolic' => $this->vitalsLatest->bp_diastolic ?? null,
            'patient_temp' => $this->vitalsLatest->patient_temp ?? null,
            'patient_weight' => $this->vitalsLatest->patient_weight ?? null,
            'patient_height' => $this->vitalsLatest->patient_height ?? null,
            'patient_pulse_rate' => $this->vitalsLatest->patient_pulse_rate ?? null,
            'patient_heart_rate' => $this->vitalsLatest->patient_heart_rate ?? null,
            'patient_respiratory_rate' => $this->vitalsLatest->patient_respiratory_rate ?? null,
            'complaints' => $this->consult_notes->complaint ?? null,
            'history' => $this->consult_notes->history ?? null,
            'initial_diagnosis' => $this->consultNotes->initialdx ?? null,
            'final_diagnosis' => $this->consultNotes->finaldx ?? null,
            'treatment_notes' => $this->plan ?? null,
            'prescription' => $this->prescription ?? null,
        ];
    }
}
