<?php

namespace App\Http\Resources\API\V1\Consultation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PendingFinalDxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient_name' => ($this->patient->first_name ?? null) . ', ' . ($this->patient->middle_name ?? 'N/a') . ' ' . ($this->patient->last_name ?? null),
            'gender' => $this->patient->gender,
            'birthdate' => $this->patient->birthdate ? Carbon::parse($this->patient->birthdate)->format('m/d/Y') : null,
            'address' => ($this->patient->householdFolder->address ?? null) . ', ' . ($this->patient->householdFolder->barangay->name ?? null),
            'bp_systolic' => $this->vitalsLatest->bp_systolic ?? null,
            'bp_diastolic' => $this->vitalsLatest->bp_diastolic ?? null,
            'bmi' => ($this->vitalsLatest->patient_bmi ?? null),
            'bmi_class' => ($this->vitalsLatest->patient_bmi_class ?? null),
            'weight' => ($this->vitalsLatest->patient_weight ?? null),
            'height' => ($this->vitalsLatest->patient_height ?? null),
            'waist' => ($this->vitalsLatest->patient_weight ?? null),
            'temp' => ($this->vitalsLatest->patient_temp ?? null),
            'heart_rate' => ($this->vitalsLatest->patient_heart_rate ?? null),
            'respiratory_rate' => ($this->vitalsLatest->patient_respiratory_rate ?? null),
            'pulse_rate' => ($this->vitalsLatest->patient_pulse_rate ?? null),
            'complaints' => $this->consultNotes->complaints ?? null,
            'complaint_remarks' => $this->consultNotes->complaint ?? null,
        ];
    }
}
