<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibPatientVaccineStatus;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Libraries\LibVaccineStatus;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientVaccineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'facility_code' => 'required|exists:facilities,code',
            'vaccines.*.vaccine_id' => 'required|exists:lib_vaccines,vaccine_id',
            'vaccines.*.vaccine_date' => 'nullable',
            'vaccines.*.status_id' => 'required|exists:lib_vaccine_statuses,status_id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of Patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of User',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'vaccine_id' => [
                'description' => 'ID of Vaccine',
                'example' => fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray()),
            ],
            'vaccines_date' => [
                'description' => 'Date of Vaccine',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'status_id' => [
                'description' => 'Status of Vaccine',
                'example' => fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray()),
            ],
        ];
    }
}
