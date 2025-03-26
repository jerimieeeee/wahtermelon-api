<?php

namespace App\Http\Resources\API\V1\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return match ($request->program) {
            'mc' => [
                'name' => $this->name,
                'age' => $this->age,
                'address' => $this->address,
                'birthdate' => $this->birthdate,
                'date_of_registration' => $this->date_of_registration,
                'lmp_date' => $this->lmp_date,
                'edc_date' => $this->edc_date,
                'delivery_date' => $this->delivery_date,

            ],
            'fp' => [
                'name' => $this->name,
                'age' => $this->age,
                'gender' => $this->gender,
                'address' => $this->address,
                'birthdate' => $this->birthdate,
                'date_of_registration' => $this->date_of_registration,
                'client_type' => $this->client_type,
                'enrollment_date' => $this->enrollment_date,
                'method' => $this->method,
                'dropout_date' => $this->dropout_date,
                'dropout_reasons' => $this->dropout_reasons,
                'remarks' => $this->remarks,

            ],
            'bt' => [
                'name' => $this->name,
                'age' => $this->age,
                'gender' => $this->gender,
                'address' => $this->address,
                'birthdate' => $this->birthdate,
                'blood_type_code' => $this->blood_type_code,

            ],
            'sn' => [
                'name' => $this->name,
                'gender' => $this->gender,
                'address' => $this->address,
                'birthdate' => $this->birthdate,
                'age' => $this->age,

            ],
            default => [
                'name' => $this->name,
                'gender' => $this->gender,
                'address' => $this->address,
            ],
        };

    }
}
