<?php

namespace Database\Factories\V1\Consultation;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Consultation\ConsultNotes>
 */
class ConsultNotesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'complaint' => fake()->sentence(),
            'history' => fake()->sentence(),
            'physical_exam' => fake()->sentence(),
            'idx_remarks' => fake()->sentence(),
            'fdx_remarks' => fake()->sentence(),
            'plan' => fake()->sentence(),
            'complaint_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
        ];
    }
}
