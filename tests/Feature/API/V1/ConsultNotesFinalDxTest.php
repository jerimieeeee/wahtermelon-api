<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use App\Models\V1\Libraries\LibIcd10;
use Tests\TestCase;

class ConsultNotesFinalDxTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_final_dx_can_be_created()
    {
        $response = $this->post('api/v1/consultation/cn-fdx', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            "fdx" => [
                [
                    "icd10_code" => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
                    "fdx_remark" => fake()->sentence(),
                ],
                [
                    "icd10_code" => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
                    "fdx_remark" => fake()->sentence(),
                ],
            ]
        ]);
        $response->assertCreated();
    }

    public function test_consultation_final_dx_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $fdx = ConsultNotesFinalDx::factory()->create();

        $response = $this->delete('api/v1/consultation/cn-fdx/'. $fdx->id, []);
        $response->assertSessionHasNoErrors();
    }
}
