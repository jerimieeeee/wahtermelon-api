<?php

namespace Database\Factories\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Libraries\LibDiagnosis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Consultation\ConsultNotesInitialDx>
 */
class ConsultNotesInitialDxFactory extends Factory
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
            'class_id' => fake()->randomElement(LibDiagnosis::pluck('id')->toArray()),
            'dx_remarks' => fake()->sentence(),
        ];
    }
}
