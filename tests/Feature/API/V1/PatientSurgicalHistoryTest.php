<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientSurgicalHistory;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientSurgicalHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_surgical_history_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create()->toArray();
        $patientSurgicalHistory = PatientSurgicalHistory::factory()->create()->toArray();
        $response = $this->post('api/v1/patient-surgical-history/history', $patientSurgicalHistory);
        $response->assertCreated();
    }

    public function test_patient_surgical_history_can_be_deleted()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patientSurgicalHistory = PatientSurgicalHistory::factory()->create();

        $response = $this->delete('api/v1/patient-surgical-history/history/'.$patientSurgicalHistory->id, []);
        $response->assertOk();
    }
}
