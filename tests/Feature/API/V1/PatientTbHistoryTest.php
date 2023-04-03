<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\TBDots\PatientTbHistory;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientTbHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_patient_tb_history_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create()->toArray();
        $patientTbHistory = PatientTbHistory::factory()->create()->toArray();
        $response = $this->post('api/v1/tbdots/patient-tb-history', $patientTbHistory);
        $response->assertCreated();
    }

    public function test_patient_tb_history_can_be_deleted()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patientTbHistory = PatientTbHistory::factory()->create();

        $response = $this->delete('api/v1/tbdots/patient-tb-history/'.$patientTbHistory->id);
        $response->assertOk();
    }
}
