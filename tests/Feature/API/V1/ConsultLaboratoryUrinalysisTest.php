<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryUrinalysis;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryUrinalysisTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_urinalysis_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryUrinalysis::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-urinalysis', $lab);
        $response->assertCreated();
    }
}
