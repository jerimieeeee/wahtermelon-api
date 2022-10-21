<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChildcareConsultTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_childcare_consult_can_be_created()
    {
        $response = $this->post('api/v1/childcare-consult', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'visit_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'visit_ended' => fake()->boolean,
        ]);
        $response->assertCreated();
    }
}
