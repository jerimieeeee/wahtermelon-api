<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientMcPreRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_mc_pre_register_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create(['gender' => 'F'])->toArray();
        $preregistration = PatientMcPreRegistration::factory()->make()->toArray();
        $response = $this->post('api/v1/maternal-care/mc-preregistrations', array_merge($preregistration, ['patient_id' => $patient['id']]));
        $response->assertCreated();
    }
}
