<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\TBDots\PatientTb;
use App\Models\V1\TBDots\PatientTbCaseFinding;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientTbCaseFindingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_patient_tb_case_finding_can_be_created(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create()->toArray();
        $patientTb = PatientTb::factory()->create()->toArray();
        $patientTbCaseFinding = PatientTbCaseFinding::factory()->create()->toArray();
        $response = $this->post('api/v1/tbdots/patient-tb-casefinding', array_merge($patientTbCaseFinding, ['patient_tb_id' => $patientTb['id']], ['patient_id' => $patientTb['patient_id']]));
        $response->assertCreated();
    }
}
