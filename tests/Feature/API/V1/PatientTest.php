<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdevBreastfed;
use App\Models\V1\Libraries\LibBloodType;
use App\Models\V1\Libraries\LibCivilStatus;
use App\Models\V1\Libraries\LibEducation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PatientTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_model_patient_can_be_instantiated(): void
    {
        $patient = Patient::factory()->create();
        $this->assertModelExists($patient);
    }

    public function test_patient_can_be_created()
    {
        $gender = fake()->randomElement(['male', 'female']);
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
        $response->assertCreated();
    }

    public function test_patient_can_show_all_records()
    {
        $response = $this->get('api/v1/patient');
        $response->assertOk();
    }

    public function test_patient_can_show_specific_record()
    {
        $id = fake()->randomElement(ConsultCcdevBreastfed::pluck('patient_id')->toArray());
        $response = $this->get("api/v1/patient/$id");
        $response->assertOk();
    }
}
