<?php

namespace Tests\Feature\API\V1;

use App\Models\V1\Libraries\LibDiagnosis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiagnosisLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
}
