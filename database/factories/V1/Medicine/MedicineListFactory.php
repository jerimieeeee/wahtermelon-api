<?php

namespace Database\Factories\V1\Medicine;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibKonsultaMedicine;
use App\Models\V1\Libraries\LibMedicine;
use App\Models\V1\Libraries\LibMedicineDoseRegimen;
use App\Models\V1\Libraries\LibMedicineDurationFrequency;
use App\Models\V1\Libraries\LibMedicinePreparation;
use App\Models\V1\Libraries\LibMedicinePurpose;
use App\Models\V1\Libraries\LibMedicineRoute;
use App\Models\V1\Libraries\LibMedicineUnitOfMeasurement;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Medicine\MedicineList>
 */
class MedicineListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'brand_name' => fake()->word(),
            'medicine_code' => fake()->randomElement(LibMedicine::pluck('hprodid')->toArray()),
            'konsulta_medicine_code' => fake()->randomElement(LibKonsultaMedicine::pluck('code')->toArray()),
            'added_medicine' => fake()->word(),
            'dosage_quantity' => fake()->numberBetween(1, 500),
            'dosage_uom' => fake()->randomElement(LibMedicineUnitOfMeasurement::pluck('code')->toArray()),
            'dose_regimen' => fake()->randomElement(LibMedicineDoseRegimen::pluck('code')->toArray()),
            'medicine_purpose' => fake()->randomElement(LibMedicinePurpose::pluck('code')->toArray()),
            'duration_intake' => fake()->numberBetween(1, 50),
            'duration_frequency' => fake()->randomElement(LibMedicineDurationFrequency::pluck('code')->toArray()),
            'quantity' => fake()->numberBetween(1, 50),
            'quantity_preparation' => fake()->randomElement(LibMedicinePreparation::pluck('code')->toArray()),
            'medicine_route' => fake()->randomElement(LibMedicineRoute::pluck('code')->toArray()),
        ];
    }
}
