<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\ConsultNcdRiskQuestionnaire;
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
        $consult = Consult::factory()->create(['pt_group' => 'ncd'])->toArray();
        $ncdRisk = ConsultNcdRiskAssessment::factory()->create()->toArray();
        $ncdRiskQuestionnaire = ConsultNcdRiskQuestionnaire::factory()->create()->toArray();
        $response = $this->post('api/v1/non-communicable-disease/risk-questionnaire', array_merge($ncdRisk, $ncdRiskQuestionnaire, ['consult_id' => $consult['id']]));
        $response->assertCreated();
    }
}
