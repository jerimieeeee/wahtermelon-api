<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibBloodType;
use App\Models\V1\Libraries\LibCivilStatus;
use App\Models\V1\Libraries\LibEducation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Libraries\LibOccupationCategory;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_all_blood_types(): void
    {
        $response = $this->get('api/v1/libraries/blood-types');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_blood_types(): void
    {
        $code = fake()->randomElement(LibBloodType::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/blood-types/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_civil_statuses(): void
    {
        $response = $this->get('api/v1/libraries/civil-statuses');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_civil_status(): void
    {
        $code = fake()->randomElement(LibCivilStatus::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/civil-statuses/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_civil_education(): void
    {
        $response = $this->get('api/v1/libraries/education');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_education(): void
    {
        $code = fake()->randomElement(LibEducation::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/education/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_occupation_categories(): void
    {
        $response = $this->get('api/v1/libraries/occupation-categories');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_occupation_category(): void
    {
        $code = fake()->randomElement(LibOccupationCategory::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/occupation-categories/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_occupations(): void
    {
        $response = $this->get('api/v1/libraries/occupations');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_occupations(): void
    {
        $code = fake()->randomElement(LibOccupation::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/occupations/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_pwd_types(): void
    {
        $response = $this->get('api/v1/libraries/pwd-types');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_pwd_types(): void
    {
        $code = fake()->randomElement(LibPwdType::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/pwd-types/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_religions(): void
    {
        $response = $this->get('api/v1/libraries/religions');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_religion(): void
    {
        $code = fake()->randomElement(LibReligion::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/religions/'.$code);
        $response->assertStatus(200);
    }

    public function test_can_view_all_suffix_names(): void
    {
        $response = $this->get('api/v1/libraries/suffix-names');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_suffix_name(): void
    {
        $code = fake()->randomElement(LibSuffixName::pluck('code')->toArray());
        $response = $this->get('api/v1/libraries/suffix-names/'.$code);
        $response->assertStatus(200);
    }
}
