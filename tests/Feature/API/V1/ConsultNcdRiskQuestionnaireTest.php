<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\NCD\ConsultNcdRiskQuestionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNcdRiskQuestionnaireTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_ncd_risk_questionnaire_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $ncdRiskQuestionnaire = ConsultNcdRiskQuestionnaire::factory()->make()->toArray();
        $response = $this->post('api/v1/non-communicable-disease/risk-questionnaire', $ncdRiskQuestionnaire);
        $response->assertCreated();
    }
}
