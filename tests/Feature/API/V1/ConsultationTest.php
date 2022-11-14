<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use Tests\TestCase;

class ConsultationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_can_be_created()
    {
        $response = $this->post('api/v1/consultation/cn-records', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'physician_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'consult_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'is_pregnant' => fake()->boolean(),
            'consult_done' => fake()->boolean(),
            'pt_group' => fake()->randomElement(['mc','ncd','cc']),
        ]);
        $response->assertCreated();
    }

    public function test_consultation_can_show_specific_record()
    {
        $id = fake()->randomElement(Consult::pluck('id')->toArray());
        $response = $this->get("api/v1/consultation/cn-records/$id");
        $response->assertOk();
    }
}
