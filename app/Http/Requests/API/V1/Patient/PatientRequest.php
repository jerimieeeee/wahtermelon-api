<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibBloodType;
use App\Models\V1\Libraries\LibCivilStatus;
use App\Models\V1\Libraries\LibEducation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Str;

class PatientRequest extends FormRequest
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
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'suffix_name' => 'required|exists:lib_suffix_names,code',
            'birthdate' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'mothers_name' => 'required',
            'gender' => 'required',
            'lib_gender_identity_code' => 'nullable|exists:lib_gender_identities,code',
            'mobile_number' => 'required|min:11|max:13',
            'pwd_type_code' => 'exists:lib_pwd_types,code',
            'indegenous_flag' => 'boolean',
            'blood_type_code' => 'sometimes|exists:lib_blood_types,code',
            'religion_code' => 'required|exists:lib_religions,code',
            'occupation_code' => 'required|exists:lib_occupations,code',
            'education_code' => 'required|exists:lib_education,code',
            'civil_status_code' => 'required|exists:lib_civil_statuses,code',
            'consent_flag' => 'boolean',
            'image_url' => 'nullable|url',
            'difficulty_seeing' => 'nullable',
            'difficulty_hearing' => 'nullable',
            'difficulty_walking' => 'nullable',
            'difficulty_remembering' => 'nullable',
            'difficulty_self_care' => 'nullable',
            'difficulty_speaking' => 'nullable',
            'attendant_cc_flag' => 'boolean',
            'attendant_mc_flag' => 'boolean',
            'attendant_tb_flag' => 'boolean',
            'attendant_ab_flag' => 'boolean',
            'attendant_ml_flag' => 'boolean',
            'attendant_fp_flag' => 'boolean',
            'attendant_cv_flag' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'birthdate.before' => 'The birthdate must not be future date.',
        ];
    }

    public function bodyParameters()
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
            /*'facility_code' => [
                'description' => 'ID of facility library',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],*/
            'last_name' => [
                'description' => 'Last name of the patient.',
                'example' => fake()->lastName(),
            ],
            'first_name' => [
                'description' => 'First name of the patient.',
                'example' => fake()->firstName($gender),
            ],
            'middle_name' => [
                'description' => 'Middle name of the patient.',
                'example' => $middle = fake()->lastName(),
            ],
            'suffix_name' => [
                'description' => 'Suffix name of the patient.',
                'example' => $gender == 'male' ? fake()->randomElement(LibSuffixName::pluck('code')->toArray()) : 'NA',
            ],
            'birthdate' => [
                'description' => 'Date of birth of the patient.',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'mothers_name' => [
                'description' => 'Mother\'s name of the patient',
                'example' => fake()->firstName('female').' '.$middle,
            ],
            'gender' => [
                'description' => 'Gender of the patient.',
                'example' => substr(Str::ucfirst($gender), 0, 1),
            ],
            'mobile_number' => [
                'description' => 'Mobile number of the patient',
                'example' => fake()->phoneNumber(),
            ],
            'pwd_type_code' => [
                'description' => 'Code of PWD type library',
                'example' => fake()->randomElement(LibPwdType::pluck('code')->toArray()),
            ],
            'blood_type_code' => [
                'description' => 'Code of blood type library',
                'example' => fake()->randomElement(LibBloodType::pluck('code')->toArray()),
            ],
            'religion_code' => [
                'description' => 'Code of religion library',
                'example' => fake()->randomElement(LibReligion::pluck('code')->toArray()),
            ],
            'occupation_code' => [
                'description' => 'Code of occupation library',
                'example' => fake()->randomElement(LibOccupation::pluck('code')->toArray()),
            ],
            'education_code' => [
                'description' => 'ID of education library',
                'example' => fake()->randomElement(LibEducation::pluck('code')->toArray()),
            ],
            'civil_status_code' => [
                'description' => 'Code of civil status library',
                'example' => fake()->randomElement(LibCivilStatus::pluck('code')->toArray()),
            ],
        ];
    }
}
