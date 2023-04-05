<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\TBDots\PatientTbPe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientTbPeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_patient_tb_pe_can_be_created(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $patient = Patient::factory()->create()->toArray();
        $patientTbPe = PatientTbPe::factory()->create()->toArray();
        $response = $this->post('api/v1/tbdots/patient-tb-pe', $patientTbPe);
        $response->assertCreated();
    }
}
