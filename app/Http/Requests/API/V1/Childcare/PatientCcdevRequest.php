<?php

namespace App\Http\Requests\API\V1\Childcare;

use App\Models\User;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;

class PatientCcdevRequest extends FormRequest
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
            'birth_weight' => 'required',
            'mothers_id' => 'required|exists:patients,id',
            'ccdev_ended' => 'required|boolean',
            'admission_date' => 'required|date|date_format:Y-m-d',
            'discharge_date' => 'required|date|date_format:Y-m-d',
            'nbs_filter' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'facility_code' => [
                'description' => 'code of facility.',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'birth_weight' => [
                'description' => 'birth weight of patient',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'mothers_id' => [
                'description' => 'ID of mother',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'admission_date' => [
                'description' => 'Date of Admission',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'discharge_date' => [
                'description' => 'Date of Discharge',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'nbs_filter' => [
                'description' => 'New born screen filter number',
                'example' => fake()->regexify('[0-9]{10}')
            ],
        ];

    }
}
