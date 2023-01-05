<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Libraries\LibFpMethod;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientMenstrualHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientMenstrualHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_menstrual_history_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create()->toArray();
        $patientMenstrualHistory = PatientMenstrualHistory::factory()->create()->toArray();
        $response = $this->post('api/v1/patient-menstrual-history/history', $patientMenstrualHistory);
        $response->assertCreated();
    }
}
