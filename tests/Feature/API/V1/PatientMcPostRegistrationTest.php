<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientMcPostRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_mc_post_register_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create(['gender' => 'F'])->toArray();
        $postregistration = PatientMcPostRegistration::factory()->make()->toArray();
        $response = $this->post('api/v1/maternal-care/mc-postregistrations', array_merge($postregistration,['patient_id' => $patient['id']]));
        $response->assertCreated();
    }
}
