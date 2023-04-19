<?php

namespace App\Http\Requests\API\V1\Appointment;

use App\Models\V1\Libraries\LibAppointment;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'appointment.*.appointment_code' => 'required|exists:lib_appointments,code',
            'appointment_date' => 'date|date_format:Y-m-d|required',
            'referral_facility_code' => [
                function ($attribute, $value, $fail) {
                    $appointmentCodes = $this->input('appointment.*.appointment_code');
                    if (in_array('REF', $appointmentCodes) && empty($value)) {
                        $fail('The referral facility code is required when appointment is Referral.');
                    }
                },
                'exists:facilities,code',
            ],
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of Patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'referral_facility_code' => [
                'description' => 'Facility Code of Referral',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'appointment_code' => [
                'description' => 'Code of Appointment',
                'example' => fake()->randomElement(LibAppointment::pluck('code')->toArray()),
            ],
            'appointment_date' => [
                'description' => 'Date of Appointment',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
        ];
    }
}
