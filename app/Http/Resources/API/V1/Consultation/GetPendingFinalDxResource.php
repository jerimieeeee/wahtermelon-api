<?php

namespace App\Http\Resources\API\V1\Consultation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetPendingFinalDxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient_id' => $this->patient_id,
            'notes_id' => $this->consultNotes->id,
            'is_konsulta' => $this->is_konsulta ? 'YES' : 'NO',
            'consult_id' => $this->id,
            'first_name' => $this->patient->first_name,
            'middle_name' => $this->patient->middle_name,
            'last_name' => $this->patient->last_name,
            'patient_name' => ($this->patient->last_name ?? null) . ', ' . ($this->patient->first_name ?? 'N/a') . ' ' . ($this->patient->middle_name ?? null),
            'consult_date' => $this->consult_date ? Carbon::parse($this->consult_date)->format('m/d/Y') : null,
            'physician_name' => ($this->physician->last_name ?? null) . ', ' . ($this->physician->first_name ?? null) . ' ' . ($this->physician->middle_name ?? null),
            'enocder_name' => ($this->user->last_name ?? null) . ', ' . ($this->user->first_name ?? null) . ' ' . ($this->user->middle_name ?? null),
//            'bp_systolic' => $this->vitalsLatest->bp_systolic ?? null,
        ];
    }
}
