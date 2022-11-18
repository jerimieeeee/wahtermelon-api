<?php

namespace App\Http\Requests\API\V1\Consultation;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultRequest extends FormRequest
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
            'consult_date' => 'required|date|date_format:Y-m-d H:i:s',
            'physician_id' => 'nullable|exists:users,id',
            'is_pregnant' => 'nullable|boolean',
            'consult_done' => 'required|boolean',
            'pt_group' => 'required',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'consult_date' => [
                'description' => 'Date Consult',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'physician_id' => [
                'description' => 'ID of Physician',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'is_pregnant' => [
                'description' => 'Is patient pregnant?',
                'is_pregnant' => fake()->boolean,
            ],
            'consult_done' => [
                'description' => 'Is consult done?',
                'consult_done' => fake()->boolean,
            ],
            'pt_group' => [
                'description' => 'Patient Group',
                'example' => fake()->randomElement(['mc','ncd','cc']),
            ],
        ];

    }
}
