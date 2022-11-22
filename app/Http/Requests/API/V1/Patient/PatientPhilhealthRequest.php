<?php

namespace App\Http\Requests\API\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibMemberRelationship;
use App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus;
use App\Models\V1\Libraries\LibPhilhealthMembershipCategory;
use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use App\Models\V1\Libraries\LibPhilhealthPackageType;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PatientPhilhealthRequest extends FormRequest
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
            'philhealth_id' => 'required|min:12|max:14',
            'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'enlistment_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'effectivity_year' => 'required',
            'enlistment_status_id' => 'required|exists:lib_philhealth_enlistment_statuses,id',
            'package_type_id' => 'required|exists:lib_philhealth_package_types,id',
            'membership_type_id' => 'required|exists:lib_philhealth_membership_types,id',
            'membership_category_id' => 'required|exists:lib_philhealth_membership_categories,id',
            'member_pin' => 'required_if:membership_type_id,DD|min:12|max:14',
            'member_last_name' => 'required_if:membership_type_id,DD',
            'member_first_name' => 'required_if:membership_type_id,DD',
            'member_middle_name' => 'nullable',
            'member_suffix_name' => 'required_if:membership_type_id,DD|exists:lib_suffix_names,code',
            'member_birthdate' => 'required_if:membership_type_id,DD|date|date_format:Y-m-d|before:tomorrow',
            'member_gender' => 'required_if:membership_type_id,DD',
            'member_relation_id' => 'required_if:membership_type_id,DD|exists:lib_member_relationships,id',
            'employer_pin' => 'required_with:employer_address|nullable',
            'employer_address' => 'required_with:employer_pin|nullable',
        ];
    }

    public function bodyParameters()
    {
        $gender = fake()->randomElement(['male', 'female']);
        $membershipType = fake()->randomElement(LibPhilhealthMembershipType::pluck('id')->toArray());
        return [
            'philhealth_id' => [
                'description' => 'Philhealth ID of the Patient',
                'example' => fake()->numerify('############')
            ],
            'facility_code' => [
                'description' => 'ID of facility library',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'enlistment_date' => [
                'description' => 'Enlistment date of the patient',
                'example' => fake()->dateTimeInInterval('-'. fake()->numberBetween(1,7) .' week')->format('Y-m-d')
            ],
            'effectivity_year' => [
                'description' => 'Effectivity year of enlistment',
                'example' => fake()->year('now')
            ],
            'enlistment_status_id' => [
                'description' => 'Enlistment status of the patient',
                'example' => fake()->randomElement(LibPhilhealthEnlistmentStatus::pluck('id')->toArray())
            ],
            'package_type_id' => [
                'description' => 'Package type of enlistment',
                'example' => fake()->randomElement(LibPhilhealthPackageType::pluck('id')->toArray())
            ],
            'membership_type_id' => [
                'description' => 'Membership type of the patient',
                'example' => $membershipType
            ],
            'membership_category_id' => [
                'description' => 'Membership category of the patient',
                'example' => fake()->randomElement(LibPhilhealthMembershipCategory::pluck('id')->toArray())
            ],
            'member_pin' => [
                'description' => 'Philhealth id of the primary member',
                'example' => $membershipType == 'DD' ? fake()->numerify('############') : null
            ],
            'member_last_name' => [
                'description' => 'Last name of the primary member',
                'example' => $membershipType == 'DD' ? fake()->lastName() : null
            ],
            'member_first_name' => [
                'description' => 'First name of the primary member',
                'example' => $membershipType == 'DD' ? fake()->firstName($gender) : null
            ],
            'member_middle_name' => [
                'description' => 'Middle name of the primary member',
                'example' => $membershipType == 'DD' ? fake()->optional()->lastName() : null
            ],
            'member_suffix_name' => [
                'description' => 'Suffix name of the primary member',
                'example' => $membershipType == 'DD' && $gender == 'male' ? fake()->randomElement(LibSuffixName::pluck('code')->toArray()) : null
            ],
            'member_birthdate' => [
                'description' => 'Date of birth of the primary member',
                'example' => $membershipType == 'DD' ? fake()->date('Y-m-d', 'now') : null
            ],
            'member_gender' => [
                'description' => 'Gender of the primary member',
                'example' => $membershipType == 'DD' ? substr(Str::ucfirst($gender), 0, 1) : null
            ],
            'member_relation_id' => [
                'description' => 'Relationship of the patient to the primary member',
                $membershipType == 'DD' ? fake()->randomElement(LibMemberRelationship::pluck('id')->toArray()) : null
            ],
            'employer_pin' => [
                'description' => 'Employer id',
                'example' => fake()->numerify('############')
            ],
            'employer_address' => [
                'description' => 'Employer address',
                'example' => fake()->address()
            ],
        ];
    }
}
