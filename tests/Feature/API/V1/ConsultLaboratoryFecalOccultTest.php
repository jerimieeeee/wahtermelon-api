<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratoryFecalOccult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryFecalOccultTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_laboratory_fecal_occult_can_store_data(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $lab = ConsultLaboratoryFecalOccult::factory()->make()->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-fecal-occult', $lab);
        $response->assertCreated();
    }
}
