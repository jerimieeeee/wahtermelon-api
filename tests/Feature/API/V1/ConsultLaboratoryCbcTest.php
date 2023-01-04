<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Laboratory\ConsultLaboratoryCbc;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultLaboratoryCbcTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_laboratory_cbc_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $request = ConsultLaboratory::factory()->create();
        $lab = ConsultLaboratoryCbc::factory()->make(['patient_id' => $request->patient_id, 'consult_id' => $request->consult_id, 'request_id' => $request->id])->toArray();
        $response = $this->post('api/v1/laboratory/consult-laboratory-cbc', $lab);
        $response->assertCreated();
    }
}
