<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryEcg;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryEcgTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_ecg_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryEcg::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-ecg', $lab);
        $response->assertCreated();
    }
}
