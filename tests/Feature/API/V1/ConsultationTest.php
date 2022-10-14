<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //Consultation Patient
    public function test_childcare_patient_can_be_created()
    {
        // $response = $this->post('api/v1/childcare', [
        //     'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
        //     'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
        //     'birth_weight' => fake()->randomFloat(),
        //     'ccdev_ended' => fake()->boolean,
        //     'mothers_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
        //     'admission_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        //     'discharge_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        // ]);
        // $response->assertCreated();
    }
}
