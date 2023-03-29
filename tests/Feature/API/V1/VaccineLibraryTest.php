<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibVaccine;
use Tests\TestCase;

class VaccineLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //Childcare Vaccines Library
    public function test_can_view_all__vaccines()
    {
        $response = $this->get('api/v1/libraries/vaccine');
        $response->assertStatus(200);
    }

    public function test_can_view_specific_vaccine(): void
    {
        $code = fake()->randomElement(LibVaccine::pluck('vaccine_id')->toArray());
        $response = $this->get('api/v1/libraries/vaccine/'.$code);
        $response->assertStatus(200);
    }
}
