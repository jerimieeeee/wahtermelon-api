<?php

namespace App\Http\Requests\API\V1\Childcare;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class ConsultCcdevRequest extends FormRequest
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
            'visit_date' => 'required|date|date_format:Y-m-d',
            'visit_ended' => 'required|boolean',
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
            'visit_date' => [
                'description' => 'Date of visit',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'visit_ended' => [
                'description' => 'visit ended?',
                'example' => fake()->boolean(),
            ],
        ];
    }
}
