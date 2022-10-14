<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Childcare\Ccdev;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Libraries\LibEbfReason;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChildcareTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //Childcare Patient
    public function test_childcare_patient_can_be_created()
    {
        $response = $this->post('api/v1/childcare-patient', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'birth_weight' => fake()->randomFloat(2, 0, 1),
            'ccdev_ended' => fake()->boolean,
            'mothers_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'admission_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'discharge_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ]);
        $response->assertCreated();
    }

    //Childcare Consult
    public function test_childcare_consult_can_be_created()
    {
        $response = $this->post('api/v1/childcare-consult', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'visit_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'visit_ended' => fake()->boolean,
        ]);
        $response->assertCreated();
    }

     //Childcare Breastfed
    public function test_childcare_breastfed_can_be_created()
    {
        $response = $this->post('api/v1/childcare-breastfed', [
            'patient_ccdevs_id' => fake()->randomElement(PatientCcdev::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'bfed_month1' => fake()->boolean,
            'bfed_month2' => fake()->boolean,
            'bfed_month3' => fake()->boolean,
            'bfed_month4' => fake()->boolean,
            'bfed_month5' => fake()->boolean,
            'bfed_month6' => fake()->boolean,
            'reason_id' => fake()->randomElement(LibEbfReason::pluck('reason_id')->toArray()),
            'ebf_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'deleted_at' => fake()->date($format = 'Y-m-d', $max = 'now'),
        ]);
        $response->assertCreated();
    }

         //Childcare Vaccine
         public function test_childcare_vaccines_can_be_created()
         {
             $response = $this->post('api/v1/childcare-vaccine', [
                 'patient_ccdev_id' => fake()->randomElement(PatientCcdev::pluck('id')->toArray()),
                 'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
                 'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
                 'vaccine_id' => fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray()),
                 'vaccine_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
             ]);
             $response->assertOk();
         }

}
