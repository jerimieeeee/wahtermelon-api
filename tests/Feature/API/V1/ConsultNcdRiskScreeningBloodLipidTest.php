<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\NCD\ConsultNcdRiskScreeningBloodLipid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNcdRiskScreeningBloodLipidTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_ncd_risk_screening_blood_lipid_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $ncdScreeningLipid = ConsultNcdRiskScreeningBloodLipid::factory()->make()->toArray();
        $response = $this->post('api/v1/non-communicable-disease/risk-screening-blood-lipid', $ncdScreeningLipid);
        $response->assertCreated();
    }
}
