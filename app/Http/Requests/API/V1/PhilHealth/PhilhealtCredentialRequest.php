<?php

namespace App\Http\Requests\API\V1\PhilHealth;

use App\Models\User;
use App\Models\V1\Libraries\LibPhilhealthProgram;
use Illuminate\Foundation\Http\FormRequest;

class PhilhealtCredentialRequest extends FormRequest
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
            'program_code' => 'required|exists:lib_philhealth_programs,code',
            'facility_name' => 'required',
            'accreditation_number' => 'required',
            'pmcc_number' => 'required',
            'software_certification_id' => 'required',
            'cipher_key' => 'required',
            'username' => 'nullable',
            'password' => 'nullable',
            'token' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        $pmcc = fake()->bothify('Z#####');
        $user = User::with('facility')->whereNotNull('facility_code')->inRandomOrder()->limit(1)->first();

        return [
            'facility_code' => [
                'example' => $user->facility_code,
            ],
            'user_id' => [
                'example' => $user->id,
            ],
            'program_code' => [
                'example' => fake()->randomElement(LibPhilhealthProgram::pluck('code')->toArray()),
            ],
            'facility_name' => [
                'example' => $user->facility->facility_name,
            ],
            'accreditation_number' => [
                'example' => fake()->bothify('P########'),
            ],
            'pmcc_number' => [
                'example' => $pmcc,
            ],
            'software_certification_id' => [
                'example' => 'KON-DUMMYSCERTZ'.$pmcc,
            ],
            'cipher_key' => [
                'example' => 'PHilheaLthDuMmyciPHerKeyS',
            ],
            'username' => [
                'example' => 'TEST',
            ],
            'password' => [
                'example' => 'TEST',
            ],
            'token' => [
                'example' => fake()->sha256(),
            ],
        ];
    }
}
