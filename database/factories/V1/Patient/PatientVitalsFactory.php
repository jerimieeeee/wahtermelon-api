<?php

namespace Database\Factories\V1\Patient;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient\PatientVitals>
 */
class PatientVitalsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'vitals_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
            'patient_temp' => fake()->numberBetween(35, 40),
            'patient_height' => fake()->numberBetween(100, 200),
            'patient_weight' => fake()->numberBetween(40, 200),
            'patient_head_circumference' => fake()->numberBetween(0, 30),
            'patient_skinfold_thickness' => fake()->numberBetween(0, 30),
            'bp_systolic' => fake()->numberBetween(100, 200),
            'bp_diastolic' => fake()->numberBetween(70, 100),
            'patient_heart_rate' => fake()->numberBetween(60, 100),
            'patient_respiratory_rate' => fake()->numberBetween(12, 60),
            'patient_pulse_rate' => fake()->numberBetween(60, 100),
            'patient_spo2' => fake()->numberBetween(60, 100),
            'patient_chest' => fake()->numberBetween(24, 150),
            'patient_abdomen' => fake()->numberBetween(24, 150),
            'patient_waist' => fake()->numberBetween(24, 150),
            'patient_hip' => fake()->numberBetween(24, 150),
            'patient_limbs' => fake()->numberBetween(60, 100),
            'patient_muac' => fake()->numberBetween(60, 100),
            'patient_left_vision_acuity' => fake()->numberBetween(20, 90),
            'patient_right_vision_acuity' => fake()->numberBetween(20, 90),
        ];
    }
}
