<?php

namespace Database\Factories\V1\NCD;

use App\Models\V1\Libraries\LibNcdEyeComplaint;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\NCD\ConsultNcdRiskCasdt2Vision>
 */
class ConsultNcdRiskCasdt2VisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'casdt2_id' => fake()->randomElement(ConsultNcdRiskAssessment::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'eye_complaint' => fake()->randomElement(LibNcdEyeComplaint::pluck('code')->toArray()),
        ];
    }
}
