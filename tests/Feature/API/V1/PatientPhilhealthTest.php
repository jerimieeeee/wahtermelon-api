<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Patient\PatientPhilhealth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientPhilhealthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_philhealth_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = PatientPhilhealth::factory()->create()->toArray();
        $response = $this->post('api/v1/patient-philhealth/philhealth', $patient);
        $response->assertCreated();
    }
}
