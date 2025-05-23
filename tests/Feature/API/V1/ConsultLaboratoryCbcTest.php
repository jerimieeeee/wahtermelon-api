<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryCbc;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryCbcTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_cbc_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryCbc::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-cbc', $lab);
        $response->assertCreated();
    }
}
