<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\MaternalCare\ConsultMcPrenatal;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultMcPrenatalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consult_mc_prenatal_can_store_data()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patient = Patient::factory()->create(['gender' => 'F'])->toArray();
        $preregistration = PatientMcPreRegistration::factory()->make()->toArray();
        $request = array_merge($preregistration,['patient_id' => $patient['id']]);

        $response = $this->post('api/v1/maternal-care/mc-preregistrations', $request);
        //dd($response->getData()->patient_mc_id);
        $response->assertCreated();

        $prenatal = ConsultMcPrenatal::factory()->make()->toArray();
        $response = $this->post('api/v1/maternal-care/mc-prenatal', array_merge($prenatal,['patient_id' => $patient['id'], 'patient_mc_id' => $response->getData()->patient_mc_id]));
        $response->assertOk();
    }
}
