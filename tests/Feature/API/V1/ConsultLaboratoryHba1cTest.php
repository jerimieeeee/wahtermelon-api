<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryHba1c;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryHba1cTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_hba1c_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryHba1c::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-hba1c', $lab);
        $response->assertCreated();
    }
}
