<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryFecalysis;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryFecalysisTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_fecalysis_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryFecalysis::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-fecalysis', $lab);
        $response->assertCreated();
    }
}
