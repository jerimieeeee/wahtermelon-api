<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdevBreastfed;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_patient_can_be_instantiated(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create();
        $this->assertModelExists($patient);
    }

    public function test_patient_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        PhilhealthCredential::factory()->create(['program_code' => 'kp']);
        $patient = Patient::factory()->make()->toArray();
        $response = $this->post('api/v1/patient', $patient);
        $response->assertCreated();
    }

    public function test_patient_can_show_all_records()
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->get('api/v1/patient');
        $response->assertOk();
    }

    public function test_patient_can_show_specific_record()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $id = fake()->randomElement(ConsultCcdevBreastfed::pluck('patient_id')->toArray());
        $response = $this->get("api/v1/patient/$id");
        $response->assertOk();
    }
}
