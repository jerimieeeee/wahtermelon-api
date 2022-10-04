<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibIcd10;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Icd10LibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
