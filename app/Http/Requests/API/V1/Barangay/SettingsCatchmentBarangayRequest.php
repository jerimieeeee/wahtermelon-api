<?php

namespace App\Http\Requests\API\V1\Barangay;

use App\Models\V1\PSGC\Barangay;
use Illuminate\Foundation\Http\FormRequest;

class SettingsCatchmentBarangayRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'year' => 'required',
            'barangay' => 'required|array',
            'barangay.*.barangay_code' => 'required|exists:barangays,code',
            'barangay.*.population' => 'nullable|numeric',
            'barangay.*.population_opt' => 'nullable|numeric',
            'barangay.*.population_wra' => 'nullable|numeric',
            'barangay.*.household' => 'nullable|numeric',
            'barangay.*.zod' => 'nullable|boolean',
        ];
    }

    public function bodyParameters()
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
            'year' => [
                'example' => fake()->year('now'),
            ],
            'barangay_code' => [
                'example' => fake()->randomElement(Barangay::pluck('code')->toArray()),
            ],
            'population' => [
                'example' => fake()->randomNumber(),
            ],
            'population_opt' => [
                'example' => fake()->randomNumber(),
            ],
            'population_wra' => [
                'example' => fake()->randomNumber(),
            ],
            'household' => [
                'example' => fake()->randomNumber(),
            ],
            'zod' => [
                'example' => fake()->boolean(),
            ],
        ];
    }
}
