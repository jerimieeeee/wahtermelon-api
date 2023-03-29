<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryOralGlucose;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryOralGlucoseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_oral_glucose_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryOralGlucose::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-oral-glucose', $lab);
        $response->assertCreated();
    }
}
