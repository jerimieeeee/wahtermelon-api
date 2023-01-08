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
            LibNcdAnswerSeeder::class,
            LibNcdAnswerS2Seeder::class,
            LibNcdSmokingAnswerSeeder::class,
            LibNcdClientTypeSeeder::class,
            LibNcdLocationSeeder::class,
            LibNcdPhysicalExamAnswerSeeder::class,
            LibNcdRiskStratificationChartSeeder::class,
            LibNcdRiskStratificationSeeder::class,
            LibNcdAlocoholIntakeAnswerSeeder::class,
            LibNcdRiskScreeningUrineKetonesSeeder::class,
            LibNcdRiskScreeningUrineProteinSeeder::class,
            LibNcdRecordTargetOrganSeeder::class,
            LibNcdRecordDiagnosisSeeder::class,
            LibNcdRecordCounsellingSeeder::class,
            LibMedicineDurationFrequencySeeder::class,
            LibMedicinePreparationSeeder::class,
            LibKonsultaMedicineGenericSeeder::class,
            LibKonsultaMedicineSaltSeeder::class,
            LibKonsultaMedicineFormSeeder::class,
            LibKonsultaMedicineStrengthSeeder::class,
            LibKonsultaMedicineUnitSeeder::class,
            LibKonsultaMedicinePackageSeeder::class,
            LibKonsultaMedicineSeeder::class,
            LibMedicinePurposeSeeder::class,
            LibPhilhealthProgramSeeder::class,
            LibMedicalHistorySeeder::class,
            LibMedicalHistoryCategorySeeder::class,
            LibPatientSocialHistoryAnswerSeeder::class,
            LibLaboratorySeeder::class,
            LibLaboratoryCategorySeeder::class,
            LibLaboratoryStatusSeeder::class,
            LibLaboratoryChestxrayFindingsSeeder::class,
            LibLaboratoryChestxrayObservationSeeder::class,
            LibLaboratoryFindingsSeeder::class,
            LibLaboratoryResultSeeder::class,
            LibLaboratorySputumCollectionSeeder::class,
            LibFpMethodSeeder::class,
            LibLaboratoryStoolColorSeeder::class,
            LibLaboratoryStoolConsistencySeeder::class,
            LibLaboratoryBloodInStoolSeeder::class,
        ]);
    }
}
