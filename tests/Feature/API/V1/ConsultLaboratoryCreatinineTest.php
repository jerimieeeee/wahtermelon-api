<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Laboratory\ConsultLaboratoryCreatinine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryCreatinineTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_laboratory_creatinine_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryCreatinine::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-creatinine', $lab);
        $response->assertCreated();
    }
}
