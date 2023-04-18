<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\TBDots\PatientTb;
use App\Models\V1\TBDots\PatientTbCaseHolding;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientTbCaseHoldingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_patient_tb_case_holding_can_be_created(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $patientTb = PatientTb::factory()->create()->toArray();
        $patientTbCaseHolding = PatientTbCaseHolding::factory()->create()->toArray();
        $response = $this->post('api/v1/tbdots/patient-tb-caseholding', array_merge($patientTbCaseHolding, ['patient_tb_id' => $patientTb['id']], ['patient_id' => $patientTb['patient_id']]));
        $response->assertCreated();
    }
}
