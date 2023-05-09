<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientChildcareTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // Childcare Patient
    public function test_childcare_patient_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        Patient::factory()->create();

        $response = $this->post('api/v1/child-care/cc-records', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'birth_weight' => fake()->randomFloat(2, 0, 1),
            'ccdev_ended' => fake()->boolean,
            'mothers_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'admission_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d H:i:s'),
            'discharge_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d H:i:s'),
            'nbs_filter' => fake()->regexify('[0-9]{10}'),
        ]);
        $response->assertCreated();
    }

    public function test_child_care_patient_can_show_specific_record()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $id = fake()->randomElement(PatientCcdev::pluck('patient_id')->toArray());
        $response = $this->get("api/v1/child-care/cc-records/$id");
        $response->assertOk();
    }
}
