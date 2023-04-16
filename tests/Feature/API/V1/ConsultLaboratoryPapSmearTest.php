<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryPapsmear;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryPapSmearTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_consult_laboratory_pap_smear_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryPapsmear::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-papsmear', $lab);
        $response->assertCreated();
    }
}
