<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryChestXray;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryChestXrayTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_chest_xray_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryChestXray::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-chestxray', $lab);
        $response->assertCreated();
    }
}
