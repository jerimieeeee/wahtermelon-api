<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibComplaint;
use App\Models\V1\Libraries\LibDiagnosis;
use App\Models\V1\Libraries\LibIcd10;
use Tests\TestCase;

class ConsultationLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //Libraries for Chief Complaint
    public function test_can_view_all_consult_complaint()
    {
        $response = $this->get('api/v1/libraries/complaint');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_consult_complaint(): void
    {
        $code = fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray());
        $response = $this->get('api/v1/libraries/complaint/'.$code);
        $response->assertStatus(200);
    }

    //Libraries for Diagnoses
    public function test_can_view_all_consult_diagnosis()
    {
        $response = $this->get('api/v1/libraries/diagnosis');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_consult_diagnosis(): void
    {
        $code = fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray());
        $response = $this->get('api/v1/libraries/diagnosis/'.$code);
        $response->assertStatus(200);
    }

    //Libraries for ICD10s
    public function test_can_view_all_consult_icd10()
    {
        $response = $this->get('api/v1/libraries/icd10');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_consult_icd10(): void
    {
        $code = fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray());
        $response = $this->get('api/v1/libraries/icd10/'.$code);
        $response->assertStatus(200);
    }
}
