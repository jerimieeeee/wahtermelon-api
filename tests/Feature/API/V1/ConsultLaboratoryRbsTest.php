<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryRbs;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryRbsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_rbs_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryRbs::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-rbs', $lab);
        $response->assertCreated();
    }
}
