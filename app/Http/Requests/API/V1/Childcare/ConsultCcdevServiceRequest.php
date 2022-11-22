<?php

namespace App\Http\Requests\API\V1\Childcare;

use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Libraries\LibCcdevService;
use App\Models\V1\Libraries\LibVaccineStatus;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultCcdevServiceRequest extends FormRequest
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
            'services.*.service_id' => 'required|exists:lib_ccdev_services,service_id',
            'services.*.services_date' => 'nullable',
            'services.*.status_id' => 'required|exists:lib_vaccine_statuses,status_id',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of Patient',
                'example' => fake()->randomElement(PatientCcdev::pluck('patient_id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of User',
                'example' => fake()->randomElement(PatientCcdev::pluck('user_id')->toArray()),
            ],
            'service_id' => [
                'description' => 'ID of Childcare Services',
                'example' => fake()->randomElement(LibCcdevService::pluck('service_id')->toArray()),
            ],
            'service_date' => [
                'description' => 'Date of Service',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'status_id' => [
                'description' => 'Status of Service',
                'example' => fake()->randomElement(LibVaccineStatus::pluck('status_id')->toArray()),
            ],
        ];
    }
}
