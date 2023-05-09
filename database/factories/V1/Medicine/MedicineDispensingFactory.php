<?php

namespace Database\Factories\V1\Medicine;

use App\Models\User;
use App\Models\V1\Medicine\MedicinePrescription;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Medicine\MedicineDispensing>
 */
class MedicineDispensingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Patient::factory()->create();
        $quantity = fake()->numberBetween(1, 50);
        $unitPrice = fake()->numberBetween(1, 500);
        $totalAmount = $quantity * $unitPrice;

        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'dispensing_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
            'prescription_id' => fake()->randomElement(MedicinePrescription::pluck('id')->toArray()),
            'dispense_quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_amount' => $totalAmount,
            'remarks' => fake()->sentence(),
        ];
    }
}
