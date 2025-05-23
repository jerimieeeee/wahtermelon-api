<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\Patient\Patient;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNcdRiskAssessmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_ncd_risk_assessment_test_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create()->toArray();
        $consult = Consult::factory()->create(['pt_group' => 'ncd'])->toArray();
        $patientNcd = PatientNcd::factory()->create()->toArray();
        $consultNcdRiskAssessment = ConsultNcdRiskAssessment::factory()->make()->toArray();
        $response = $this->post('api/v1/non-communicable-disease/risk-assessment', array_merge($consultNcdRiskAssessment, ['patient_ncd_id' => $patientNcd['id']], ['consult_id' => $consult['id']], ['patient_id' => $patient['id']], ['date_enrolled' => $patientNcd['date_enrolled']]));
        $response->assertCreated();
    }
}
