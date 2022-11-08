<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibDiagnosis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultNotesInitialDxTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_initial_dx_can_be_created()
    {
        $response = $this->post('api/v1/consultation/cn-idx', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'idx' => [fake()->randomElement(LibDiagnosis::pluck('class_id')->toArray())],
            'idx_remark' => [fake()->sentence()],
        ]);
        $response->assertCreated();
    }
}
