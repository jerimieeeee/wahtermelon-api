<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryFbs;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryFbsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_fbs_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryFbs::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-fbs', $lab);
        $response->assertCreated();
    }
}
