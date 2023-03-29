<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PhilhealthCredentialTest extends TestCase
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
        $credentials = PhilhealthCredential::factory()->make()->toArray();
        $response = $this->post('api/v1/settings/philhealth-credentials', $credentials);
        $response->assertCreated();
    }
}
