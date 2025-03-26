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
            'gender_identity' => $this->patient->gender_identity->desc,
            'birthdate' => $this->patient->birthdate,
            'living_arrangement' => $this->living_arrangement_type->desc,
            'area_of_residence' => $this->patient->household_folder->barangay->name,
        ];
    }
}
