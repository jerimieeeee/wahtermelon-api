<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\V1\Libraries\LibFpMethod;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientMenstrualHistoryRequest extends FormRequest
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
            'menarche' => 'numeric|nullable',
            'lmp' => 'nullable|date|date_format:Y-m-d',
            'period_duration' => 'numeric|nullable',
            'cycle' => 'numeric|nullable',
            'pads_per_day' => 'numeric|nullable',
            'onset_sexual_intercourse' => 'numeric|nullable',
            'method' => 'nullable|exists:lib_fp_methods,code',
            'menopause' => 'boolean',
            'menopause_age' => 'numeric|nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient.',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'menarche' => [
                'description' => 'age of menarche',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'lmp' => [
                'description' => 'date of LMP',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'period_duration' => [
                'description' => 'duration of period',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'cycle' => [
                'description' => 'cycle of menstruation',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'pads_per_day' => [
                'description' => 'how many pads per day?',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'onset_sexual_intercourse' => [
                'description' => 'how many times of sexual intercourse?',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
            'method' => [
                'description' => 'Family planning method use?',
                'example' => fake()->randomElement(LibFpMethod::pluck('id')->toArray()),
            ],
            'menopause' => [
                'description' => 'is patient menopause?',
                'example' => fake()->boolean,
            ],
            'menopause_age' => [
                'description' => 'Age when patient is menopause',
                'example' => fake()->randomFloat(2, 2, 5),
            ],
        ];
    }
}
