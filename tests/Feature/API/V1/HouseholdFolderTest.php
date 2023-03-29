<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\Libraries\LibFamilyRole;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
use Tests\TestCase;

class HouseholdFolderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_household_folder()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $householdFactory = HouseholdFolder::factory()->make()->toArray();
        $response = $this->post('api/v1/households/household-folders', $householdFactory + [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'family_role_code' => fake()->randomElement(LibFamilyRole::pluck('code')->toArray()),
        ]);

        $response->assertCreated();
    }
}
