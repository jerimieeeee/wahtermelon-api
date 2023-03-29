<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\ConsultNcdRiskScreeningBloodGlucose;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNcdRiskScreeningBloodGlucoseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_ncd_risk_screening_blood_glucose_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $ncdRisk = ConsultNcdRiskAssessment::factory()->make()->toArray();
        $ncdScreeningGlucose = ConsultNcdRiskScreeningBloodGlucose::factory()->make()->toArray();
        $response = $this->post('api/v1/non-communicable-disease/risk-screening-blood-glucose', $ncdScreeningGlucose);
        $response->assertCreated();
    }
}
