<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
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
    // public function test_consultation_chief_complaint_be_created()
    // {
    //     // $response = $this->post('api/v1/complaint', [
    //     //     'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
    //     //     'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
    //     //     'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
    //     //     'complaint' => [fake()->randomElement(LibComplaint::pluck('complaint_id')->toArray())],
    //     //     'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
    //     //     'complaint_date' => [fake()->date($format = 'Y-m-d', $max = 'now')],
    //     // ]);
    //     // // dd($response);
    //     // $response->assertCreated();
    // }
}
