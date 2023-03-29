<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_laboratory_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratory::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratories', $lab);
        $response->assertCreated();
    }
}
