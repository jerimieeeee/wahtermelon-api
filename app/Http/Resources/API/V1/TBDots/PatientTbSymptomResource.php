<?php

namespace App\Http\Resources\API\V1\TBDots;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientTbSymptomResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'bcpain' => $this->bcpain,
            'cough' => $this->cough,
            'drest' => $this->drest,
            'dexertion' => $this->dexertion,
            'fever' => $this->fever,
            'hemoptysis' => $this->hemoptysis,
            'nsweats' => $this->nsweats,
            'pedema' => $this->pedema,
            'wloss' => $this->wloss,
            'symptoms_remarks' => $this->symptoms_remarks
        ];
    }
}
