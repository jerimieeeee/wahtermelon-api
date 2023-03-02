<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * Define the model's default state.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryGramStain>
 */
class ConsultLaboratoryGramStainFactory extends Factory
{
    public function definition()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'GRMS']);
        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'referral_facility' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'nugen_score' => fake()->randomDigit(),
            'fungal_elements' => fake()->randomDigit(),
            'pus_cells' => fake()->randomDigit(),
            'gram_negative' => fake()->randomDigit(),
            'request_id' => $consult->id,
            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
