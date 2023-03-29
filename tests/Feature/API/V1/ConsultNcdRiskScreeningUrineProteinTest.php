<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\ConsultNcdRiskScreeningUrineProtein;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNcdRiskScreeningUrineProteinTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_ncd_risk_screening_urine_protein_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $ncdRisk = ConsultNcdRiskAssessment::factory()->make()->toArray();
        $ncdScreeningProtein = ConsultNcdRiskScreeningUrineProtein::factory()->make()->toArray();
        $response = $this->post('api/v1/non-communicable-disease/risk-screening-urine-protein', $ncdScreeningProtein);
        $response->assertCreated();
    }
}
