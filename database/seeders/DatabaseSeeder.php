<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            LibBloodTypeSeeder::class,
            LibPeSeeder::class,
            LibVaccineSeeder::class,
            LibVaccineStatusSeeder::class,
            LibCivilStatusSeeder::class,
            LibComplaintSeeder::class,
            LibDiagnosisSeeder::class,
            LibEducationSeeder::class,
            LibIcd10NotifiableSeeder::class,
            LibIcd10Seeder::class,
            LibPwdTypeSeeder::class,
            LibReligionSeeder::class,
            LibSuffixNameSeeder::class,
            LibOccupationCategorySeeder::class,
            LibOccupationSeeder::class,
            LibMcRiskFactorSeeder::class,
            LibMcDeliveryLocationSeeder::class,
            LibMcOutcomeSeeder::class,
            LibMcLocationSeeder::class,
            LibMcAttendantSeeder::class,
            LibMcPresentationSeeder::class,
            LibMcPregnancyTerminationSeeder::class,
            LibMcVisitTypeSeeder::class,
            LibEbfReasonSeeder::class,
            LibWeightForAgeSeeder::class,
            LibWeightForHeightSeeder::class,
            LibLengthHeightForAgeSeeder::class,
            LibFamilyRoleSeeder::class,
            LibPhilhealthMembershipTypeSeeder::class,
            LibPhilhealthMembershipCategorySeeder::class,
            LibPhilhealthPackageTypeSeeder::class,
            LibPhilhealthEnlistmentStatusSeeder::class,
            LibMemberRelationshipSeeder::class,
            LibMcServiceSeeder::class,
            LibCcdevServicesSeeder::class,
            LibDesignationSeeder::class,
            LibEmployerSeeder::class,
            LibPtGroupSeeder::class,
            LibMedicineUnitOfMeasurementSeeder::class,
            LibMedicineDoseRegimenSeeder::class,
            LibMedicineDurationFrequencySeeder::class,
            LibMedicinePreparationSeeder::class,
        ]);
    }
}
