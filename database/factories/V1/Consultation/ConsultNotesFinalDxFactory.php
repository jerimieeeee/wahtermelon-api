<?php

namespace Database\Factories\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibIcd10;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Consultation\ConsultNotesFinalDx>
 */
class ConsultNotesFinalDxFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'notes_id' => fake()->randomElement(ConsultNotes::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'icd10_code' => fake()->randomElement(LibIcd10::pluck('icd10_code')->toArray()),
            'fdx_remark' => fake()->sentence(),
        ];
    }
}
