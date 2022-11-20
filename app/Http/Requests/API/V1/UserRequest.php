<?php

namespace App\Http\Requests\API\V1;

use App\Models\V1\Libraries\LibSuffixName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Str;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'suffix_name' => 'required|exists:lib_suffix_names,code',
            'gender' => 'required',
            'birthdate' => 'required|date',
            'contact_number' => 'required|min:11|max:13', //'required|min:11|max:11|unique:users' . (request()->has('id') ? ',contact_number, ' . request()->input('id') : ''),
            //'username' => 'required|min:4|unique:users',// . (request()->has('id') ? ',username, ' . request()->input('id') : ''),
            'email' => 'nullable|email|unique:users' . (request()->has('id') ? ',email, ' . request()->input('id') : ''),
            'is_active' => 'nullable|boolean',
            'photo_url' => 'nullable|url',
            'tin_number' => 'sometimes|max:9',
            'accreditation_number' => 'sometimes|max:14',
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    //->uncompromised()
            ],
            'password_confirmation' => 'required:password'
        ];
    }

    public function bodyParameters()
    {
        $gender = fake()->randomElement(['male', 'female']);
        $fakePassword = fake()->password();
        return [
            'last_name' => [
                'description' => 'Last name of the user.',
                'example' => fake()->lastName(),
            ],
            'first_name' => [
                'description' => 'First name of the user.',
                'example' => fake()->firstName($gender),
            ],
            'middle_name' => [
                'description' => 'Middle name of the user.',
                'example' => $middle = fake()->lastName(),
            ],
            'suffix_name' => [
                'description' => 'Suffix name of the user.',
                'example' => $gender == 'male' ? fake()->randomElement(LibSuffixName::pluck('code')->toArray()) : 'NA',
            ],
            'birthdate' => [
                'description' => 'Date of birth of the user.',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'gender' => [
                'description' => 'Gender of the user.',
                'example' => substr(Str::ucfirst($gender), 0, 1),
            ],
            'contact_number' => [
                'description' => 'Contact number of the user',
                'example' => fake()->phoneNumber(),
            ],
            'photo_url' => [
                'description' => 'Photo url of the user',
                'example' => fake()->optional()->url(),
            ],
            'tin_number' => [
                'description' => 'Tin number of the user',
                'example' => fake()->optional()->randomDigit(),
            ],
            'accreditation_number' => [
                'description' => 'Accreditation number of the user',
                'example' => fake()->optional()->randomDigit(),
            ],
            'email' => [
                'description' => 'Email of the user',
                'example' => fake()->safeEmail(),
            ],
            'password' => [
                'description' => 'Password of the user',
                'example' => $fakePassword,
            ],
            'password_confirmation' => [
                'description' => 'Confirmation Password of the user',
                'example' => $fakePassword,
            ],
        ];
    }
}
