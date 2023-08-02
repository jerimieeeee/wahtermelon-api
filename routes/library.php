<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/libraries')->group(function () {
    Route::get('regions', [\App\Http\Controllers\API\V1\PSGC\RegionController::class, 'index'])->name('region.index');
    Route::get('regions/{region}', [\App\Http\Controllers\API\V1\PSGC\RegionController::class, 'show'])->name('region.show');

    Route::get('provinces', [\App\Http\Controllers\API\V1\PSGC\ProvinceController::class, 'index'])->name('province.index');
    Route::get('provinces/{province}', [\App\Http\Controllers\API\V1\PSGC\ProvinceController::class, 'show'])->name('province.show');

    //Route::get('districts', [\App\Http\Controllers\API\V1\PSGC\DistrictController::class, 'index'])->name('district.index');
    //Route::get('districts/{district}', [\App\Http\Controllers\API\V1\PSGC\DistrictController::class, 'show'])->name('district.show');

    //Route::get('cities', [\App\Http\Controllers\API\V1\PSGC\CityController::class, 'index'])->name('city.index');
    //Route::get('cities/{city}', [\App\Http\Controllers\API\V1\PSGC\CityController::class, 'show'])->name('city.show');

    Route::get('municipalities', [\App\Http\Controllers\API\V1\PSGC\MunicipalityController::class, 'index'])->name('municipality.index');
    Route::get('municipalities/{municipality}', [\App\Http\Controllers\API\V1\PSGC\MunicipalityController::class, 'show'])->name('municipality.show');

    //Route::get('sub-municipalities', [\App\Http\Controllers\API\V1\PSGC\SubMunicipalityController::class, 'index'])->name('sub-municipality.index');
    //Route::get('sub-municipalities/{subMunicipality}', [\App\Http\Controllers\API\V1\PSGC\SubMunicipalityController::class, 'show'])->name('sub-municipality.show');

    Route::get('barangays', [\App\Http\Controllers\API\V1\PSGC\BarangayController::class, 'index'])->name('barangay.index');
    Route::get('barangays/{barangay}', [\App\Http\Controllers\API\V1\PSGC\BarangayController::class, 'show'])->name('barangay.show');

    Route::get('facilities', [\App\Http\Controllers\API\V1\PSGC\FacilityController::class, 'index'])->name('facility.index');
    Route::get('facilities/{facility}', [\App\Http\Controllers\API\V1\PSGC\FacilityController::class, 'show'])->name('facility.show');

    Route::get('blood-types', [\App\Http\Controllers\API\V1\Libraries\LibBloodTypeController::class, 'index'])->name('blood-types.index');
    Route::get('blood-types/{bloodType}', [\App\Http\Controllers\API\V1\Libraries\LibBloodTypeController::class, 'show'])->name('blood-types.show');

    Route::get('civil-statuses', [\App\Http\Controllers\API\V1\Libraries\LibCivilStatusController::class, 'index'])->name('civil-statuses.index');
    Route::get('civil-statuses/{civilStatus}', [\App\Http\Controllers\API\V1\Libraries\LibCivilStatusController::class, 'show'])->name('civil-statuses.show');

    Route::get('education', [\App\Http\Controllers\API\V1\Libraries\LibEducationController::class, 'index'])->name('education.index');
    Route::get('education/{education}', [\App\Http\Controllers\API\V1\Libraries\LibEducationController::class, 'show'])->name('education.show');

    Route::get('occupation-categories', [\App\Http\Controllers\API\V1\Libraries\LibOccupationCategoryController::class, 'index'])->name('occupation-categories.index');
    Route::get('occupation-categories/{occupationCategory}', [\App\Http\Controllers\API\V1\Libraries\LibOccupationCategoryController::class, 'show'])->name('occupation-categories.show');

    Route::get('occupations', [\App\Http\Controllers\API\V1\Libraries\LibOccupationController::class, 'index'])->name('occupations.index');
    Route::get('occupations/{occupation}', [\App\Http\Controllers\API\V1\Libraries\LibOccupationController::class, 'show'])->name('occupations.show');

    Route::get('pwd-types', [\App\Http\Controllers\API\V1\Libraries\LibPwdTypeController::class, 'index'])->name('pwd-types.index');
    Route::get('pwd-types/{pwdType}', [\App\Http\Controllers\API\V1\Libraries\LibPwdTypeController::class, 'show'])->name('pwd-types.show');

    Route::get('religions', [\App\Http\Controllers\API\V1\Libraries\LibReligionController::class, 'index'])->name('religions.index');
    Route::get('religions/{religion}', [\App\Http\Controllers\API\V1\Libraries\LibReligionController::class, 'show'])->name('religions.show');

    Route::get('suffix-names', [\App\Http\Controllers\API\V1\Libraries\LibSuffixNameController::class, 'index'])->name('suffix-names.index');
    Route::get('suffix-names/{suffixName}', [\App\Http\Controllers\API\V1\Libraries\LibSuffixNameController::class, 'show'])->name('suffix-names.show');

    Route::get('mc-attendants', [\App\Http\Controllers\API\V1\Libraries\LibMcAttendantController::class, 'index'])->name('mc-attendants.index');
    Route::get('mc-attendants/{attendant}', [\App\Http\Controllers\API\V1\Libraries\LibMcAttendantController::class, 'show'])->name('mc-attendants.show');

    Route::get('mc-delivery-locations', [\App\Http\Controllers\API\V1\Libraries\LibMcDeliveryLocationController::class, 'index'])->name('mc-delivery-locations.index');
    Route::get('mc-delivery-locations/{deliveryLocation}', [\App\Http\Controllers\API\V1\Libraries\LibMcDeliveryLocationController::class, 'show'])->name('mc-delivery-locations.show');

    Route::get('mc-locations', [\App\Http\Controllers\API\V1\Libraries\LibMcLocationController::class, 'index'])->name('mc-locations.index');
    Route::get('mc-locations/{location}', [\App\Http\Controllers\API\V1\Libraries\LibMcLocationController::class, 'show'])->name('mc-locations.show');

    Route::get('mc-outcomes', [\App\Http\Controllers\API\V1\Libraries\LibMcOutcomeController::class, 'index'])->name('mc-outcomes.index');
    Route::get('mc-outcomes/{outcome}', [\App\Http\Controllers\API\V1\Libraries\LibMcOutcomeController::class, 'show'])->name('mc-outcomes.show');

    Route::get('mc-pregnancy-terminations', [\App\Http\Controllers\API\V1\Libraries\LibMcPregnancyTerminationController::class, 'index'])->name('mc-pregnancy-termination.index');
    Route::get('mc-pregnancy-terminations/{pregnancyTermination}', [\App\Http\Controllers\API\V1\Libraries\LibMcPregnancyTerminationController::class, 'show'])->name('mc-pregnancy-termination.show');

    Route::get('mc-presentations', [\App\Http\Controllers\API\V1\Libraries\LibMcPresentationController::class, 'index'])->name('mc-presentations.index');
    Route::get('mc-presentations/{presentation}', [\App\Http\Controllers\API\V1\Libraries\LibMcPresentationController::class, 'show'])->name('mc-presentations.show');

    Route::get('mc-risk-factors', [\App\Http\Controllers\API\V1\Libraries\LibMcRiskFactorController::class, 'index'])->name('mc-risk-factors.index');
    Route::get('mc-risk-factors/{riskFactor}', [\App\Http\Controllers\API\V1\Libraries\LibMcRiskFactorController::class, 'show'])->name('mc-risk-factors.show');

    Route::get('mc-visit-type', [\App\Http\Controllers\API\V1\Libraries\LibMcVisitTypeController::class, 'index'])->name('mc-visit-type.index');
    Route::get('mc-visit-type/{visitType}', [\App\Http\Controllers\API\V1\Libraries\LibMcVisitTypeController::class, 'show'])->name('mc-visit-type.show');

    Route::get('mc-services', [\App\Http\Controllers\API\V1\Libraries\LibMcServiceController::class, 'index'])->name('mc-services.index');
    Route::get('mc-services/{mcService}', [\App\Http\Controllers\API\V1\Libraries\LibMcServiceController::class, 'show'])->name('mc-services.show');

    //Consultation Libraries
    Route::get('complaint', [\App\Http\Controllers\API\V1\Libraries\LibComplaintController::class, 'index']);
    Route::get('complaint/{id}', [\App\Http\Controllers\API\V1\Libraries\LibComplaintController::class, 'show']);
    Route::get('pe', [\App\Http\Controllers\API\V1\Libraries\LibPeController::class, 'index']);
    Route::get('pe/{id}', [\App\Http\Controllers\API\V1\Libraries\LibPeController::class, 'show']);
    Route::get('diagnosis', [\App\Http\Controllers\API\V1\Libraries\LibDiagnosisController::class, 'index']);
    Route::get('diagnosis/{id}', [\App\Http\Controllers\API\V1\Libraries\LibDiagnosisController::class, 'show']);
    Route::get('icd10', [\App\Http\Controllers\API\V1\Libraries\LibIcd10Controller::class, 'index']);
    Route::get('icd10/{id}', [\App\Http\Controllers\API\V1\Libraries\LibIcd10Controller::class, 'show']);

    //Childcare Libraries
    Route::get('vaccine', [\App\Http\Controllers\API\V1\Libraries\LibVaccineController::class, 'index']);
    Route::get('vaccine/{id}', [\App\Http\Controllers\API\V1\Libraries\LibVaccineController::class, 'show']);

    Route::get('reason', [\App\Http\Controllers\API\V1\Libraries\LibEbfReasonController::class, 'index']);
    Route::get('reason/{id}', [\App\Http\Controllers\API\V1\Libraries\LibEbfReasonController::class, 'show']);

    Route::get('cc-services', [\App\Http\Controllers\API\V1\Libraries\LibCcdevServiceController::class, 'index'])->name('cc-services.index');
    Route::get('cc-services/{ccService}', [\App\Http\Controllers\API\V1\Libraries\LibCcdevServiceController::class, 'show'])->name('cc-services.show');

    //Household
    Route::get('family-roles', [\App\Http\Controllers\API\V1\Libraries\LibFamilyRoleController::class, 'index'])->name('family-roles.index');
    Route::get('family-roles/{familyRole}', [\App\Http\Controllers\API\V1\Libraries\LibFamilyRoleController::class, 'show'])->name('family-roles.show');

    Route::get('residence-classifications', [\App\Http\Controllers\API\V1\Libraries\LibResidenceClassificationController::class, 'index'])->name('residence-classifications.index');
    Route::get('residence-classifications/{residenceClassification}', [\App\Http\Controllers\API\V1\Libraries\LibResidenceClassificationController::class, 'show'])->name('residence-classifications.show');

    //Philhealth Libraries
    Route::get('membership-types', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthMembershipTypeController::class, 'index'])->name('membership-types.index');
    Route::get('membership-types/{membershipType}', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthMembershipTypeController::class, 'show'])->name('membership-types.show');

    Route::get('membership-categories', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthMembershipCategoryController::class, 'index'])->name('membership-categories.index');
    Route::get('membership-categories/{membershipCategory}', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthMembershipCategoryController::class, 'show'])->name('membership-categories.show');

    Route::get('member-relationships', [\App\Http\Controllers\API\V1\Libraries\LibMemberRelationshipController::class, 'index'])->name('member-relationships.index');
    Route::get('member-relationships/{memberRelationship}', [\App\Http\Controllers\API\V1\Libraries\LibMemberRelationshipController::class, 'show'])->name('member-relationships.show');

    Route::get('enlistment-status', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthEnlistmentStatusController::class, 'index'])->name('enlistment-status.index');
    Route::get('enlistment-status/{enlistmentStatus}', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthEnlistmentStatusController::class, 'show'])->name('enlistment-status.show');

    Route::get('package-types', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthPackageTypeController::class, 'index'])->name('package-types.index');
    Route::get('package-types/{packageType}', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthPackageTypeController::class, 'show'])->name('package-types.show');

    Route::get('designations', [\App\Http\Controllers\API\V1\Libraries\LibDesignationController::class, 'index'])->name('designations.index');
    Route::get('designations/{designation}', [\App\Http\Controllers\API\V1\Libraries\LibDesignationController::class, 'show'])->name('designations.show');

    Route::get('employers', [\App\Http\Controllers\API\V1\Libraries\LibEmployerController::class, 'index'])->name('employers.index');
    Route::get('employers/{employer}', [\App\Http\Controllers\API\V1\Libraries\LibEmployerController::class, 'show'])->name('employers.show');

    //Pt group
    Route::get('pt-group', [\App\Http\Controllers\API\V1\Libraries\LibPtGroupController::class, 'index'])->name('pt-group.index');
    Route::get('pt-group/{ptgroup}', [\App\Http\Controllers\API\V1\Libraries\LibPtGroupController::class, 'show'])->name('pt-group.show');

    //Medicine
    Route::get('unit-of-measurements', [\App\Http\Controllers\API\V1\Libraries\LibMedicineUnitOfMeasurementController::class, 'index'])->name('unit-of-measurements.index');
    Route::get('unit-of-measurements/{unitOfMeasurement}', [\App\Http\Controllers\API\V1\Libraries\LibMedicineUnitOfMeasurementController::class, 'show'])->name('unit-of-measurements.show');

    Route::get('dose-regimens', [\App\Http\Controllers\API\V1\Libraries\LibMedicineDoseRegimenController::class, 'index'])->name('dose-regimens.index');
    Route::get('dose-regimens/{doseRegimen}', [\App\Http\Controllers\API\V1\Libraries\LibMedicineDoseRegimenController::class, 'show'])->name('dose-regimens.show');

    //NCD
    Route::get('ncd-alcohol-intake', [\App\Http\Controllers\API\V1\Libraries\LibNcdAlcoholIntakeAnswerController::class, 'index'])->name('ncd-alcohol-intake.index');
    Route::get('ncd-alcohol-intake/{alcoholIntake}', [\App\Http\Controllers\API\V1\Libraries\LibNcdAlcoholIntakeAnswerController::class, 'show'])->name('ncd-alcohol-intake.show');

    Route::get('ncd-answers', [\App\Http\Controllers\API\V1\Libraries\LibNcdAnswerController::class, 'index'])->name('ncd-answers.index');
    Route::get('ncd-answers/{answer}', [\App\Http\Controllers\API\V1\Libraries\LibNcdAnswerController::class, 'show'])->name('ncd-answers.show');

    Route::get('ncd-answers-s2', [\App\Http\Controllers\API\V1\Libraries\LibNcdAnswerS2Controller::class, 'index'])->name('ncd-answers-s2.index');
    Route::get('ncd-answers-s2/{answerS2}', [\App\Http\Controllers\API\V1\Libraries\LibNcdAnswerS2Controller::class, 'show'])->name('ncd-answers-s2.show');

    Route::get('ncd-client-types', [\App\Http\Controllers\API\V1\Libraries\LibNcdClientTypeController::class, 'index'])->name('ncd-client-types.index');
    Route::get('ncd-client-types/{clientType}', [\App\Http\Controllers\API\V1\Libraries\LibNcdClientTypeController::class, 'show'])->name('ncd-client-types.show');

    Route::get('ncd-locations', [\App\Http\Controllers\API\V1\Libraries\LibNcdLocationController::class, 'index'])->name('ncd-locations.index');
    Route::get('ncd-locations/{location}', [\App\Http\Controllers\API\V1\Libraries\LibNcdLocationController::class, 'show'])->name('ncd-locations.show');

    Route::get('ncd-physical-exam', [\App\Http\Controllers\API\V1\Libraries\LibNcdPhysicalExamAnswerController::class, 'index'])->name('ncd-physical-exam.index');
    Route::get('ncd-physical-exam/{physicalExamAnswer}', [\App\Http\Controllers\API\V1\Libraries\LibNcdPhysicalExamAnswerController::class, 'show'])->name('ncd-physical-exam.show');

    Route::get('ncd-risk-stratification-chart', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskStratificationChartController::class, 'index'])->name('ncd-risk-stratification-chart.index');
    Route::get('ncd-risk-stratification-chart/{riskStratificationChart}', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskStratificationChartController::class, 'show'])->name('ncd-risk-stratification-chart.show');

    Route::get('ncd-risk-stratification', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskStratificationController::class, 'index'])->name('ncd-risk-stratification.index');
    Route::get('ncd-risk-stratification/{riskStratification}', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskStratificationController::class, 'show'])->name('ncd-risk-stratification.show');

    Route::get('ncd-smoking', [\App\Http\Controllers\API\V1\Libraries\LibNcdSmokingAnswerController::class, 'index'])->name('ncd-smoking.index');
    Route::get('ncd-smoking/{smokingAnswer}', [\App\Http\Controllers\API\V1\Libraries\LibNcdSmokingAnswerController::class, 'show'])->name('ncd-smoking.show');

    Route::get('ncd-record-counselling', [\App\Http\Controllers\API\V1\Libraries\LibNcdRecordCounsellingController::class, 'index'])->name('ncd-record-counselling.index');
    Route::get('ncd-record-counselling/{counselling}', [\App\Http\Controllers\API\V1\Libraries\LibNcdRecordCounsellingController::class, 'show'])->name('ncd-record-counselling.show');

    Route::get('ncd-record-diagnosis', [\App\Http\Controllers\API\V1\Libraries\LibNcdRecordDiagnosisController::class, 'index'])->name('ncd-record-diagnosis.index');
    Route::get('ncd-record-diagnosis/{diagnosis}', [\App\Http\Controllers\API\V1\Libraries\LibNcdRecordDiagnosisController::class, 'show'])->name('ncd-record-diagnosis.show');

    Route::get('ncd-record-target-organ', [\App\Http\Controllers\API\V1\Libraries\LibNcdRecordTargetOrganController::class, 'index'])->name('ncd-record-target-organ.index');
    Route::get('ncd-record-target-organ/{targetOrgan}', [\App\Http\Controllers\API\V1\Libraries\LibNcdRecordTargetOrganController::class, 'show'])->name('ncd-record-target-organ.show');

    Route::get('ncd-risk-screening-urine-ketones', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskScreeningUrineKetonesController::class, 'index'])->name('ncd-risk-screening-urine-ketones.index');
    Route::get('ncd-risk-screening-urine-ketones/{riskScreeningUrineKetones}', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskScreeningUrineKetonesController::class, 'show'])->name('ncd-risk-screening-urine-ketones.show');

    Route::get('ncd-risk-screening-urine-protein', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskScreeningUrineProteinController::class, 'index'])->name('ncd-risk-screening-urine-protein.index');
    Route::get('ncd-risk-screening-urine-protein/{riskScreeningUrineProtein}', [\App\Http\Controllers\API\V1\Libraries\LibNcdRiskScreeningUrineProteinController::class, 'show'])->name('ncd-risk-screening-urine-protein.show');

    Route::get('duration-frequencies', [\App\Http\Controllers\API\V1\Libraries\LibMedicineDurationFrequencyController::class, 'index'])->name('duration-frequencies.index');
    Route::get('duration-frequencies/{durationFrequency}', [\App\Http\Controllers\API\V1\Libraries\LibMedicineDurationFrequencyController::class, 'show'])->name('duration-frequencies.show');

    Route::get('preparations', [\App\Http\Controllers\API\V1\Libraries\LibMedicinePreparationController::class, 'index'])->name('preparations.index');
    Route::get('preparations/{preparation}', [\App\Http\Controllers\API\V1\Libraries\LibMedicinePreparationController::class, 'show'])->name('preparations.show');

    Route::get('purposes', [\App\Http\Controllers\API\V1\Libraries\LibMedicinePurposeController::class, 'index'])->name('purposes.index');
    Route::get('purposes/{purpose}', [\App\Http\Controllers\API\V1\Libraries\LibMedicinePurposeController::class, 'show'])->name('purposes.show');

    //Konsulta Medicine
    Route::get('konsulta-generics', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineGenericController::class, 'index'])->name('konsulta-generics.index');
    Route::get('konsulta-generics/{medicineGeneric}', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineGenericController::class, 'show'])->name('konsulta-generics.show');

    Route::get('konsulta-salts', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineSaltController::class, 'index'])->name('konsulta-salts.index');
    Route::get('konsulta-salts/{medicineSalt}', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineSaltController::class, 'show'])->name('konsulta-salts.show');

    Route::get('konsulta-forms', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineFormController::class, 'index'])->name('konsulta-forms.index');
    Route::get('konsulta-forms/{medicineForm}', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineFormController::class, 'show'])->name('konsulta-forms.show');

    Route::get('konsulta-strengths', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineStrengthController::class, 'index'])->name('konsulta-strengths.index');
    Route::get('konsulta-strengths/{medicineStrength}', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineStrengthController::class, 'show'])->name('konsulta-strengths.show');

    Route::get('konsulta-units', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineUnitController::class, 'index'])->name('konsulta-units.index');
    Route::get('konsulta-units/{medicineUnit}', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineUnitController::class, 'show'])->name('konsulta-units.show');

    Route::get('konsulta-packages', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicinePackageController::class, 'index'])->name('konsulta-packages.index');
    Route::get('konsulta-packages/{medicinePackage}', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicinePackageController::class, 'show'])->name('konsulta-packages.show');

    Route::get('konsulta-medicines', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineController::class, 'index'])->name('konsulta-medicines.index');
    Route::get('konsulta-medicines/{medicine}', [\App\Http\Controllers\API\V1\Libraries\LibKonsultaMedicineController::class, 'show'])->name('konsulta-medicines.show');

    //PhilHealth Programs
    Route::get('philhealth-programs', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthProgramController::class, 'index'])->name('philhealth-programs.index');
    Route::get('philhealth-programs/{program}', [\App\Http\Controllers\API\V1\Libraries\LibPhilhealthProgramController::class, 'show'])->name('philhealth-programs.show');

    //Patient Medical History
    Route::get('medical-history', [\App\Http\Controllers\API\V1\Libraries\LibMedicalHistoryController::class, 'index'])->name('medical-history.index');
    Route::get('medical-history/{medicalHistory}', [\App\Http\Controllers\API\V1\Libraries\LibMedicalHistoryController::class, 'show'])->name('medical-history.show');

    //Patient Medical History Category
    Route::get('medical-history-category', [\App\Http\Controllers\API\V1\Libraries\LibMedicalHistoryCategoryController::class, 'index'])->name('medical-history-category.index');
    Route::get('medical-history-category/{medicalHistoryCategory}', [\App\Http\Controllers\API\V1\Libraries\LibMedicalHistoryCategoryController::class, 'show'])->name('medical-history-category.show');

    //Patient Social History
    Route::get('social-history', [\App\Http\Controllers\API\V1\Libraries\LibPatientSocialHistoryAnswerController::class, 'index'])->name('social-history-category.index');
    Route::get('social-history/{socialHistoryAnswer}', [\App\Http\Controllers\API\V1\Libraries\LibPatientSocialHistoryAnswerController::class, 'show'])->name('social-history-category.show');

    //Laboratory
    Route::get('laboratories', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryController::class, 'index'])->name('laboratories.index');
    Route::get('laboratories/{laboratory}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryController::class, 'show'])->name('laboratories.show');

    Route::get('laboratory-categories', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryCategoryController::class, 'index'])->name('laboratory-categories.index');

    Route::get('laboratory-statuses', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryStatusController::class, 'index'])->name('laboratory-statuses.index');
    Route::get('laboratory-statuses/{laboratoryStatus}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryStatusController::class, 'show'])->name('laboratory-statuses.show');

    Route::get('laboratory-chestxray-findings', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryChestxrayFindingsController::class, 'index'])->name('laboratory-chestxray-findings.index');
    Route::get('laboratory-chestxray-findings/{findings}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryChestxrayFindingsController::class, 'show'])->name('laboratory-chestxray-findings.show');

    Route::get('laboratory-chestxray-observations', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryChestxrayObservationController::class, 'index'])->name('laboratory-chestxray-observations.index');
    Route::get('laboratory-chestxray-observations/{observation}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryChestxrayObservationController::class, 'show'])->name('laboratory-chestxray-observations.show');

    Route::get('laboratory-findings', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryFindingsController::class, 'index'])->name('laboratory-findings.index');
    Route::get('laboratory-findings/{findings}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryFindingsController::class, 'show'])->name('laboratory-findings.show');

    Route::get('laboratory-results', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryResultController::class, 'index'])->name('laboratory-results.index');
    Route::get('laboratory-results/{result}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryResultController::class, 'show'])->name('laboratory-results.show');

    Route::get('laboratory-sputum-collection', [\App\Http\Controllers\API\V1\Libraries\LibLaboratorySputumCollectionController::class, 'index'])->name('laboratory-sputum-collection.index');
    Route::get('laboratory-sputum-collection/{collection}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratorySputumCollectionController::class, 'show'])->name('laboratory-sputum-collection.show');

    Route::get('laboratory-recommendations', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryRecommendationController::class, 'index'])->name('laboratory-recommendations.index');
    Route::get('laboratory-recommendations/{recommendation}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryRecommendationController::class, 'show'])->name('laboratory-recommendations.show');

    Route::get('laboratory-request-statuses', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryRequestStatusController::class, 'index'])->name('laboratory-request-statuses.index');
    Route::get('laboratory-request-statuses/{status}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryRequestStatusController::class, 'show'])->name('laboratory-request-statuses.show');

    Route::get('laboratory-blood-stool', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryBloodInStoolController::class, 'index'])->name('laboratory-blood-stool.index');
    Route::get('laboratory-blood-stool/{bloodStool}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryBloodInStoolController::class, 'show'])->name('laboratory-blood-stool.show');

    Route::get('laboratory-stool-color', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryStoolColorController::class, 'index'])->name('laboratory-stool-color.index');
    Route::get('laboratory-stool-color/{stoolColor}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryStoolColorController::class, 'show'])->name('laboratory-stool-color.show');

    Route::get('laboratory-stool-consistency', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryStoolConsistencyController::class, 'index'])->name('laboratory-stool-consistency.index');
    Route::get('laboratory-stool-consistency/{stoolConsistency}', [\App\Http\Controllers\API\V1\Libraries\LibLaboratoryStoolConsistencyController::class, 'show'])->name('laboratory-stool-consistency.show');

    //Patient Pregnancy History
    Route::get('pregnancy-delivery-type', [\App\Http\Controllers\API\V1\Libraries\LibPregnancyDeliveryTypeController::class, 'index'])->name('pregnancy-delivery-type.index');
    Route::get('pregnancy-delivery-type/{pregnancyDeliveryType}', [\App\Http\Controllers\API\V1\Libraries\LibPregnancyDeliveryTypeController::class, 'show'])->name('pregnancy-delivery-type.show');

    //General Survey
    Route::get('general-survey', [\App\Http\Controllers\API\V1\Libraries\LibGeneralSurveyController::class, 'index'])->name('general-survey.index');
    Route::get('general-survey/{generalSurvey}', [\App\Http\Controllers\API\V1\Libraries\LibGeneralSurveyController::class, 'show'])->name('general-survey.show');

    //Patient Management
    Route::get('management', [\App\Http\Controllers\API\V1\Libraries\LibManagementController::class, 'index'])->name('management.index');
    Route::get('management/{management}', [\App\Http\Controllers\API\V1\Libraries\LibManagementController::class, 'show'])->name('management.show');

    //Medicine Route
    Route::get('medicine-route', [\App\Http\Controllers\API\V1\Libraries\LibMedicineRouteController::class, 'index'])->name('medicine-route.index');
    Route::get('medicine-route/{medicineRoute}', [\App\Http\Controllers\API\V1\Libraries\LibMedicineRouteController::class, 'show'])->name('medicine-route.show');

    //TB Patient Source
    Route::get('tb-patient-source', [\App\Http\Controllers\API\V1\Libraries\LibTbPatientSourceController::class, 'index'])->name('tb-patient-source.index');

    //TB Registration Group
    Route::get('tb-reg-group', [\App\Http\Controllers\API\V1\Libraries\LibTbRegGroupController::class, 'index'])->name('tb-reg-group.index');

    //TB Registration Group
    Route::get('tb-previous-treatment', [\App\Http\Controllers\API\V1\Libraries\LibTbPreviousTbTreatmentController::class, 'index'])->name('tb-previous-treatment.index');

    //Yes or No answer
    Route::get('answer-yn', [\App\Http\Controllers\API\V1\Libraries\LibAnswerYnController::class, 'index'])->name('answer-yn.index');

    //TB Symptoms
    Route::get('tb-symptoms', [\App\Http\Controllers\API\V1\Libraries\LibTbSymptomsController::class, 'index'])->name('tb-symptoms.index');

    //TB Treatment Outcome
    Route::get('tb-treatment-outcome', [\App\Http\Controllers\API\V1\Libraries\LibTbTreatmentOutcomeController::class, 'index'])->name('tb-treatment-outcome.index');

    //TB PE
    Route::get('tb-pe', [\App\Http\Controllers\API\V1\Libraries\LibTbPeController::class, 'index'])->name('tb-pe.index');

    //TB Risk Factor
    Route::get('tb-risk-factor', [\App\Http\Controllers\API\V1\Libraries\LibTbRiskFactorController::class, 'index'])->name('tb-risk-factor.index');

    //TB Exam Period
    Route::get('tb-exam-period', [\App\Http\Controllers\API\V1\Libraries\LibTbExamPeriodController::class, 'index'])->name('tb-exam-period.index');

    //TB PE Answers
    Route::get('tb-pe-answer', [\App\Http\Controllers\API\V1\Libraries\LibTbPeAnswerController::class, 'index'])->name('tb-pe-answer.index');

    //TB Enrollment Type
    Route::get('tb-enroll-as', [\App\Http\Controllers\API\V1\Libraries\LibTbEnrollAsController::class, 'index'])->name('tb-enroll-as.index');

    //TB Bacteriological Status
    Route::get('tb-bact-status', [\App\Http\Controllers\API\V1\Libraries\LibTbBacteriologicalStatusController::class, 'index'])->name('tb-bact-status.index');

    //TB Anatomical Site
    Route::get('tb-anatomical-site', [\App\Http\Controllers\API\V1\Libraries\LibTbAnatomicalSiteController::class, 'index'])->name('tb-anatomical-site.index');

    //TB EPTB Site
    Route::get('tb-eptb-site', [\App\Http\Controllers\API\V1\Libraries\LibTbEptbSiteController::class, 'index'])->name('tb-eptb-site.index');

    //TB Outcome Reasons
    Route::get('tb-outcome-reason', [\App\Http\Controllers\API\V1\Libraries\LibTbOutcomeReasonController::class, 'index'])->name('tb-outcome-reason.index');

    //TB IPT Type
    Route::get('tb-ipt-type', [\App\Http\Controllers\API\V1\Libraries\LibTbIptTypeController::class, 'index'])->name('tb-ipt-type.index');

    //TB Treatment Regimen
    Route::get('tb-treatment-regimen', [\App\Http\Controllers\API\V1\Libraries\LibTbTreatmentRegimenController::class, 'index'])->name('tb-treatment-regimen.index');
    //Patient Appointment
    Route::get('appointment', [\App\Http\Controllers\API\V1\Libraries\LibAppointmentController::class, 'index'])->name('appointment.index');
    Route::get('appointment/{appointment}', [\App\Http\Controllers\API\V1\Libraries\LibAppointmentController::class, 'show'])->name('appointment.show');

    //GBV Primary Complaint
    Route::get('gbv-primary-complaint', [\App\Http\Controllers\API\V1\Libraries\LibGbvPrimaryComplaintController::class, 'index'])->name('gbv-primary-complaint.index');

    //GBV Outcome Reason
    Route::get('gbv-outcome-reason', [\App\Http\Controllers\API\V1\Libraries\LibGbvOutcomeReasonController::class, 'index'])->name('gbv-outcome-reason.index');

    //GBV Outcome Result
    Route::get('gbv-outcome-result', [\App\Http\Controllers\API\V1\Libraries\LibGbvOutcomeResultController::class, 'index'])->name('gbv-outcome-result.index');

    //GBV Neglects
    Route::get('gbv-neglect', [\App\Http\Controllers\API\V1\Libraries\LibGbvNeglectController::class, 'index'])->name('gbv-neglect.index');

    //GBV Neglects
    Route::get('gbv-info-source', [\App\Http\Controllers\API\V1\Libraries\LibGbvInfoSourceController::class, 'index'])->name('gbv-info-source.index');

    //GBV Behavioral
    Route::get('gbv-behavioral', [\App\Http\Controllers\API\V1\Libraries\LibGbvBehavioralController::class, 'index'])->name('gbv-behavioral.index');

    //GBV Services
    Route::get('gbv-services', [\App\Http\Controllers\API\V1\Libraries\LibGbvServiceController::class, 'index'])->name('gbv-services.index');

    //Child Relation
    Route::get('child-relation', [\App\Http\Controllers\API\V1\Libraries\LibGbvChildRelationController::class, 'index'])->name('child-relation.index');

    //GBV Sleeping Arrangement
    Route::get('gbv-sleeping-arrangement', [\App\Http\Controllers\API\V1\Libraries\LibGbvSleepingArrangementController::class, 'index'])->name('gbv-sleeping-arrangement.index');

    //GBV Living Arrangement
    Route::get('gbv-living-arrangement', [\App\Http\Controllers\API\V1\Libraries\LibGbvLivingArrangementController::class, 'index'])->name('gbv-living-arrangement.index');

    //GBV Economic Status
    Route::get('gbv-economic-status', [\App\Http\Controllers\API\V1\Libraries\LibGbvEconomicStatusController::class, 'index'])->name('gbv-economic-status.index');

    //GBV Outcome Verdict
    Route::get('gbv-outcome-verdict', [\App\Http\Controllers\API\V1\Libraries\LibGbvOutcomeVerdictController::class, 'index'])->name('gbv-outcome-verdict.index');

    //GBV legal filing location
    Route::get('gbv-filing-location', [\App\Http\Controllers\API\V1\Libraries\LibGbvLegalFilingLocationController::class, 'index'])->name('gbv-filing-location.index');

    //GBV conference invitee
    Route::get('gbv-conference-invitee', [\App\Http\Controllers\API\V1\Libraries\LibGbvConferenceInviteeController::class, 'index'])->name('gbv-conference-invitee.index');

    //GBV conference concern
    Route::get('gbv-conference-concern', [\App\Http\Controllers\API\V1\Libraries\LibGbvConferenceConcernController::class, 'index'])->name('gbv-conference-concern.index');

    //GBV conference mitigating factors
    Route::get('gbv-conference-mitigating', [\App\Http\Controllers\API\V1\Libraries\LibGbvConferenceMitigatingFactorController::class, 'index'])->name('gbv-conference-mitigating.index');

    //GBV conference recommendation
    Route::get('gbv-conference-recommendation', [\App\Http\Controllers\API\V1\Libraries\LibGbvConferenceRecommendationController::class, 'index'])->name('gbv-conference-recommendation.index');

    //GBV emotional abuse
    Route::get('gbv-emotional-abuse', [\App\Http\Controllers\API\V1\Libraries\LibGbvEmotionalAbuseController::class, 'index'])->name('gbv-emotional-abuse.index');

    //GBV physical abuse
    Route::get('gbv-physical-abuse', [\App\Http\Controllers\API\V1\Libraries\LibGbvPhysicalAbuseController::class, 'index'])->name('gbv-physical-abuse.index');

    //GBV sexual abuse
    Route::get('gbv-sexual-abuse', [\App\Http\Controllers\API\V1\Libraries\LibGbvSexualAbuseController::class, 'index'])->name('gbv-sexual-abuse.index');

    //GBV Perpetrator location
    Route::get('gbv-perpetrator-location', [\App\Http\Controllers\API\V1\Libraries\LibGbvPerpetratorLocationController::class, 'index'])->name('gbv-perpetrator-location.index');

    //GBV Child behavior
    Route::get('gbv-child-behavior', [\App\Http\Controllers\API\V1\Libraries\LibGbvChildBehaviorController::class, 'index'])->name('gbv-child-behavior.index');

    //GBV Disclosed type
    Route::get('gbv-disclosed-type', [\App\Http\Controllers\API\V1\Libraries\LibGbvDisclosedTypeController::class, 'index'])->name('gbv-disclosed-type.index');

    //GBV Abused episode
    Route::get('gbv-abused-episode', [\App\Http\Controllers\API\V1\Libraries\LibGbvAbusedEpisodeController::class, 'index'])->name('gbv-abused-episode.index');

    //GBV Abused site
    Route::get('gbv-abused-site', [\App\Http\Controllers\API\V1\Libraries\LibGbvAbusedSiteController::class, 'index'])->name('gbv-abused-site.index');

    //GBV Placement location
    Route::get('gbv-placement-location', [\App\Http\Controllers\API\V1\Libraries\LibGbvPlacementLocationController::class, 'index'])->name('gbv-placement-location.index');

    //GBV Placement location
    Route::get('gbv-placement-type', [\App\Http\Controllers\API\V1\Libraries\LibGbvPlacementTypeController::class, 'index'])->name('gbv-placement-type.index');

    //GBV Psych session participant
    Route::get('gbv-psych-participant', [\App\Http\Controllers\API\V1\Libraries\LibGbvPsychParticipantController::class, 'index'])->name('gbv-psych-participant.index');

    //GBV developmental screening
    Route::get('gbv-developmental-screening', [\App\Http\Controllers\API\V1\Libraries\LibGbvDevelopmentalScreeningController::class, 'index'])->name('gbv-developmental-screening.index');

    //GBV mental age
    Route::get('gbv-mental-age', [\App\Http\Controllers\API\V1\Libraries\LibGbvMentalAgeController::class, 'index'])->name('gbv-mental-age.index');

    //GBV deferral reason
    Route::get('gbv-deferral-reason', [\App\Http\Controllers\API\V1\Libraries\LibGbvDeferralReasonController::class, 'index'])->name('gbv-deferral-reason.index');

    //GBV previous interviewer
    Route::get('gbv-previous-interviewer', [\App\Http\Controllers\API\V1\Libraries\LibGbvPreviousInterviewerController::class, 'index'])->name('gbv-previous-interviewer.index');

    //GBV Filing type
    Route::get('gbv-filing-type', [\App\Http\Controllers\API\V1\Libraries\LibGbvFilingTypeController::class, 'index'])->name('gbv-filing-type.index');

    //GBV NPS Status
    Route::get('gbv-nps-status', [\App\Http\Controllers\API\V1\Libraries\LibGbvNpsStatusController::class, 'index'])->name('gbv-nps-status.index');

    //Washington Disability
    Route::get('washington-disability-question', [\App\Http\Controllers\API\V1\Libraries\LibWashingtonDisabilityQuestionController::class, 'index'])->name('washington-disability-question.index');
    Route::get('washington-disability-answer', [\App\Http\Controllers\API\V1\Libraries\LibWashingtonDisabilityAnswerController::class, 'index'])->name('washington-disability-answer.index');

    //GBV Symptoms Anogenital
    Route::get('gbv-symptoms-anogenital', [\App\Http\Controllers\API\V1\Libraries\LibGbvSymptomsAnogenitalController::class, 'index'])->name('gbv-symptoms-anogenital.index');

    //GBV Symptoms Corporal
    Route::get('gbv-symptoms-corporal', [\App\Http\Controllers\API\V1\Libraries\LibGbvSymptomsCorporalController::class, 'index'])->name('gbv-symptoms-corporal.index');

    //GBV Symptoms Behavioral
    Route::get('gbv-symptoms-behavioral', [\App\Http\Controllers\API\V1\Libraries\LibGbvSymptomsBehavioralController::class, 'index'])->name('gbv-symptoms-behavioral.index');

    //GBV Symptoms Behavioral
    Route::get('gbv-medical-impression', [\App\Http\Controllers\API\V1\Libraries\LibGbvMedicalImpressionController::class, 'index'])->name('gbv-medical-impression.index');

    //Eclaims Doc Type
    Route::get('eclaims-doc-type', [\App\Http\Controllers\API\V1\Libraries\LibEclaimsDocTypeController::class, 'index'])->name('eclaims-doc-type.index');

    //Family Planning Method
    Route::get('family-planning-method', [\App\Http\Controllers\API\V1\Libraries\LibFpMethodController::class, 'index'])->name('family-planning-method.index');
    Route::get('family-planning-method/{method}', [\App\Http\Controllers\API\V1\Libraries\LibFpMethodController::class, 'show'])->name('family-planning-method.show');

    //Family Planning History
    Route::get('family-planning-history', [\App\Http\Controllers\API\V1\Libraries\LibFpHistoryController::class, 'index'])->name('family-planning-history.index');
    Route::get('family-planning-history/{history}', [\App\Http\Controllers\API\V1\Libraries\LibFpHistoryController::class, 'show'])->name('family-planning-history.show');

    //Family Planning Client Type
    Route::get('family-planning-client-type', [\App\Http\Controllers\API\V1\Libraries\LibFpClientTypeController::class, 'index'])->name('family-planning-client-type.index');
    Route::get('family-planning-client-type/{history}', [\App\Http\Controllers\API\V1\Libraries\LibFpClientTypeController::class, 'show'])->name('family-planning-client-type.show');

    //Family Planning Pelvic Exams
    Route::get('family-planning-pelvic-exam', [\App\Http\Controllers\API\V1\Libraries\LibFpPelvicExamController::class, 'index'])->name('family-planning-pelvic-exam.index');
    Route::get('family-planning-pelvic-exam/{pelvicExam}', [\App\Http\Controllers\API\V1\Libraries\LibFpPelvicExamController::class, 'show'])->name('family-planning-pelvic-exam.show');

    //Animal Bite Anatomical Location
    Route::get('ab-anatomical-location', [\App\Http\Controllers\API\V1\Libraries\LibAbAnatomicalLocationController::class, 'index'])->name('ab-anatomical-location.index');

    //Animal Bite Animal Status
    Route::get('ab-animal-status', [\App\Http\Controllers\API\V1\Libraries\LibAbAnimalStatusController::class, 'index'])->name('ab-animal-status.index');

    //Animal Bite Animal Type
    Route::get('ab-animal-type', [\App\Http\Controllers\API\V1\Libraries\LibAbAnimalTypeController::class, 'index'])->name('ab-animal-type.index');

    //Animal Bite Exposure Type
    Route::get('ab-exposure-type', [\App\Http\Controllers\API\V1\Libraries\LibAbExposureTypeController::class, 'index'])->name('ab-exposure-type.index');

    //Animal Bite Indication Option
    Route::get('ab-indication-option', [\App\Http\Controllers\API\V1\Libraries\LibAbIndicationOptionController::class, 'index'])->name('ab-indication-option.index');

    //Animal Bite Rig Type
    Route::get('ab-rig-type', [\App\Http\Controllers\API\V1\Libraries\LibAbRigTypeController::class, 'index'])->name('ab-rig-type.index');

    //Animal Bite Vaccine Route
    Route::get('ab-vaccine-route', [\App\Http\Controllers\API\V1\Libraries\LibAbVaccineRouteController::class, 'index'])->name('ab-vaccine-route.index');

    //Animal Bite Animal Ownership
    Route::get('ab-animal-ownership', [\App\Http\Controllers\API\V1\Libraries\LibAbAnimalOwnershipController::class, 'index'])->name('ab-animal-ownership.index');

    //Family Planning Physical Exam
    Route::get('family-planning-physical-exam', [\App\Http\Controllers\API\V1\Libraries\LibFpPhysicalExamController::class, 'index'])->name('family-planning-physical-exam.index');
});
