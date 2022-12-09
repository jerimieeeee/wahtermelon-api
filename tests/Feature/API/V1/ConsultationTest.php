<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibPtGroup;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
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
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = Consult::factory()->make()->toArray();
        $response = $this->post('api/v1/consultation/records', $consult);
        $response->assertCreated();
    }

    public function test_consultation_can_show_specific_record()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $id = fake()->randomElement(Consult::pluck('patient_id')->toArray());
        $response = $this->get("api/v1/consultation/records?patient_id=$id");
        $response->assertOk();
    }
}
