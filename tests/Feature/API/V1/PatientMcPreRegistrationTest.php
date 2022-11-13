<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $patient = Patient::factory()->create(['gender' => 'F'])->toArray();
        $preregistration = PatientMcPreRegistration::factory()->make()->toArray();
        $response = $this->post('api/v1/maternal-care/mc-preregistrations', array_merge($preregistration,['patient_id' => $patient['id']]));
        $response->assertCreated();
    }

}
