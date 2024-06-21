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
            'patient_name' => ($this->last_name ?? '') . ', ' . ($this->first_name ?? '') . ' ' . ($this->middle_name ?? ''),
            'name' => ($this->first_name ?? '') . ' ' . ($this->middle_name ?? '') . ' ' . ($this->last_name ?? ''),
            'gender' => $this->gender ?? null,
            'birthdate' => $this->birthdate ? Carbon::parse($this->birthdate)->format('m/d/Y') : null,
            'address' => ($this->householdFolder->address ?? '') . ', ' . ($this->householdFolder->barangay->name ?? ''),
            'consult_no_fdx' => $this->consult_no_fdx ?? null,
            'final_dx' => $this->final_dx
        ];
    }
}
