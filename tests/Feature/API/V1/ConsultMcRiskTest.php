<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\MaternalCare\ConsultMcRisk;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultMcRiskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_mc_risk_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create(['gender' => 'F'])->toArray();
        $mcRisk = ConsultMcRisk::factory()->make()->toArray();
        $response = $this->post('api/v1/maternal-care/mc-risk-factors', array_merge($mcRisk,['patient_id' => $patient['id']]));
        $response->assertOk();
    }
}
