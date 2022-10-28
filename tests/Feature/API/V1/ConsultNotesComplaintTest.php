<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use App\Models\V1\Libraries\LibComplaint;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultNotesComplaintTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_consultation_chief_complaint_can_be_created()
    {
        //Create Consult and Consult Notes
        $response = $this->post('api/v1/consult', [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'physician_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'consult_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'is_pregnant' => fake()->boolean(),
            'consult_done' => fake()->boolean(),
            'pt_group' => fake()->randomElement(['mc','ncd','cc']),

        ]);

        $response = $this->post('api/v1/complaint', [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'complaints' => [fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray())],
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
        ]);
        $response->assertCreated();
    }
}
