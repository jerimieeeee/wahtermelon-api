<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Libraries\LibNcdRecordCounselling;
use App\Models\V1\Libraries\LibNcdRecordDiagnosis;
use App\Models\V1\Libraries\LibNcdRecordTargetOrgan;
use App\Models\V1\NCD\PatientNcd;
use App\Models\V1\NCD\PatientNcdRecord;
use App\Models\V1\NCD\PatientNcdRecordCounselling;
use App\Models\V1\NCD\PatientNcdRecordDiagnosis;
use App\Models\V1\NCD\PatientNcdRecordTargetOrgan;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PatientNcdRecordTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_patient_ncd_record_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $patientncd = PatientNcd::factory()->create()->toArray();
        $patientNcdRecord = PatientNcdRecord::factory()->make()->toArray();
        $response = $this->post('api/v1/non-communicable-disease/patient-record',
            [
                "diagnosis_code" => [
                    fake()->randomElement(LibNcdRecordDiagnosis::pluck('id')->toArray()),
                    fake()->randomElement(LibNcdRecordDiagnosis::pluck('id')->toArray()),
                ],
                "counselling_code" => [
                    fake()->randomElement(LibNcdRecordCounselling::pluck('id')->toArray()),
                    fake()->randomElement(LibNcdRecordCounselling::pluck('id')->toArray()),
                    fake()->randomElement(LibNcdRecordCounselling::pluck('id')->toArray()),
                ],
                "target_organ_code" => [
                    fake()->randomElement(LibNcdRecordTargetOrgan::pluck('id')->toArray()),
                ],
                'patient_ncd_id' => $patientncd['id'],
                'consult_ncd_risk_id' => $patientNcdRecord['consult_ncd_risk_id'],
                'patient_id' => $patientncd['patient_id'],
                'consultation_date' => $patientNcdRecord['consultation_date'],
                'palpitation_heart' => $patientNcdRecord['palpitation_heart'],
                'peripheral_pulses' => $patientNcdRecord['peripheral_pulses'],
                'abdomen' => $patientNcdRecord['abdomen'],
                'heart' => $patientNcdRecord['heart'],
                'lungs' => $patientNcdRecord['lungs'],
                'sensation_feet' => $patientNcdRecord['sensation_feet'],
            ]);
        $response->assertCreated();
    }
}
