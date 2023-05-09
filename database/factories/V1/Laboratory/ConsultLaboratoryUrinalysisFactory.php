<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryUrinalysis>
 */
class ConsultLaboratoryUrinalysisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        Patient::factory()->create();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'URN']);

        return [
            'facility_code' => $consult->facility_code,
            'consult_id' => $consult->consult_id,
            'patient_id' => $consult->patient_id,
            'user_id' => $consult->user_id,
            'request_id' => $consult->id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),

            'gravity' => fake()->word(),
            'appearance' => fake()->word(),
            'color' => fake()->colorName(),
            'glucose' => fake()->numberBetween(1, 10),
            'proteins' => fake()->numberBetween(1, 10),
            'ketones' => fake()->numberBetween(1, 10),
            'ph' => fake()->numberBetween(1, 10),
            'rb_cells' => fake()->numberBetween(1, 10),
            'wb_cells' => fake()->numberBetween(1, 10),
            'bacteria' => fake()->numberBetween(1, 10),
            'crystals' => fake()->numberBetween(1, 10),
            'bladder_cells' => fake()->numberBetween(1, 10),
            'squamous_cells' => fake()->numberBetween(1, 10),
            'tubular_cells' => fake()->numberBetween(1, 10),
            'broad_cast' => fake()->numberBetween(1, 10),
            'epithelial_cast' => fake()->numberBetween(1, 10),
            'granular_cast' => fake()->numberBetween(1, 10),
            'hyaline_cast' => fake()->numberBetween(1, 10),
            'rbc_cast' => fake()->numberBetween(1, 10),
            'waxy_cast' => fake()->numberBetween(1, 10),
            'wc_cast' => fake()->numberBetween(1, 10),
            'albumin' => fake()->numberBetween(1, 10),
            'pus_cells' => fake()->numberBetween(1, 10),

            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
