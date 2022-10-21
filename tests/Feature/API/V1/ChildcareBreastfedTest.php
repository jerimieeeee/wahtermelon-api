<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Libraries\LibEbfReason;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChildcareBreastfedTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
        ]);
        $response->assertCreated();
    }
}
