<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratorySputum;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratorySputumTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_sputum_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratorySputum::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-sputum', $lab);
        $response->assertCreated();
    }
}
