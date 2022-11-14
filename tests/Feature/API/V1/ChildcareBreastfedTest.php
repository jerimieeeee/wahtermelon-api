<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdevBreastfed;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Libraries\LibBloodType;
use App\Models\V1\Libraries\LibCivilStatus;
use App\Models\V1\Libraries\LibEbfReason;
use App\Models\V1\Libraries\LibEducation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Tests\TestCase;
use Illuminate\Support\Str;

class ChildcareBreastfedTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_childcare_breastfed_can_be_created()
    {
        //Create User
        $gender = fake()->randomElement(['male', 'female']);
        $response = $this->post('api/v1/register', [
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName($gender),
            'middle_name' => fake()->lastName(),
            'suffix_name' => 'NA',
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'birthdate' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'contact_number' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'password' => 'Password2!',
            'password_confirmation' => 'Password2!',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

            //Create Patient
            $response = $this->post('api/v1/patient', [
            'facility_id' => fake()->randomElement(Facility::pluck('id')->toArray()),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName($gender),
            'middle_name' => $middle = fake()->lastName(),
            'suffix_name' => $gender == 'male' ? fake()->randomElement(LibSuffixName::pluck('code')->toArray()) : 'NA',
            'gender' => substr(Str::ucfirst($gender), 0, 1),
            'birthdate' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'mothers_name' => fake()->firstName('female') . ' ' . $middle,
            'mobile_number' => fake()->phoneNumber(),
            'pwd_type_code' => fake()->randomElement(LibPwdType::pluck('code')->toArray()),
            'indegenous_flag' => fake()->boolean,
            'blood_type_code' => fake()->randomElement(LibBloodType::pluck('code')->toArray()),
            'religion_code' => fake()->randomElement(LibReligion::pluck('code')->toArray()),
            'occupation_code' => fake()->randomElement(LibOccupation::pluck('code')->toArray()),
            'education_code' => fake()->randomElement(LibEducation::pluck('code')->toArray()),
            'civil_status_code' => fake()->randomElement(LibCivilStatus::pluck('code')->toArray()),
            'consent_flag' => fake()->boolean,
        ]);

             $response = $this->post('api/v1/child-care/cc-records', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'birth_weight' => fake()->randomFloat(2, 0, 1),
            'ccdev_ended' => fake()->boolean,
            'mothers_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'admission_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'discharge_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'nbs_filter' => fake()->regexify('[0-9]{10}')
        ]);

            //Create Bfed
            $response = $this->post('api/v1/child-care/cc-breastfed', [
            'patient_ccdevs_id' => fake()->randomElement(PatientCcdev::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'bfed_month1' => fake()->boolean,
            'bfed_month2' => fake()->boolean,
            'bfed_month3' => fake()->boolean,
            'bfed_month4' => fake()->boolean,
            'bfed_month5' => fake()->boolean,
            'bfed_month6' => fake()->boolean,
            'reason_id' => fake()->randomElement(LibEbfReason::pluck('reason_id')->toArray()),
            'ebf_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ]);
        $response->assertCreated();
    }

    // public function test_child_care_breastfed_can_show_specific_record()
    // {
    //     $id = fake()->randomElement(ConsultCcdevBreastfed::pluck('id')->toArray());
    //     $response = $this->get("api/v1/childcare-breastfed/$id");
    //     $response->assertOk();
    // }


}
