<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibPe;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConsultNotesPeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_physical_exam_can_be_created()
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->post('api/v1/consultation/physical-exam', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            'physical_exam' => [
                fake()->randomElement(LibPe::pluck('pe_id')->toArray()),
                fake()->randomElement(LibPe::pluck('pe_id')->toArray()),
                fake()->randomElement(LibPe::pluck('pe_id')->toArray()),
            ],
        ]);

        $response->assertCreated();
    }
}
