<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibEbfReason;
use App\Models\V1\Libraries\LibVaccine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChildcareLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     //Childcare Vaccines Library
    public function test_can_view_all_childcare_vaccines()
    {
        $response = $this->get('api/v1/libraries/vaccine');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_childcare_vaccine(): void
    {
        $code = fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray());
        $response = $this->get('api/v1/libraries/vaccine/'.$code);
        $response->assertStatus(200);
    }

    //Childcare EBF reasons Library
    public function test_can_view_all_ebf_reasons()
    {
        $response = $this->get('api/v1/libraries/reason');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_ebf_reasons(): void
    {
        $code = fake()->randomElement(LibEbfReason::pluck('reason_id')->toArray());
        $response = $this->get('api/v1/libraries/reason/'.$code);
        $response->assertStatus(200);
    }

}
