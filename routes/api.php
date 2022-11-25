<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function (){
    Route::post('login', [\App\Http\Controllers\API\Auth\AuthenticationController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\API\Auth\AuthenticationController::class, 'logout'])->middleware('auth:api');
    Route::get('email/verify/{id}', [\App\Http\Controllers\API\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/resend', [\App\Http\Controllers\API\Auth\VerificationController::class, 'resend'])->name('verification.resend');
    Route::post('forgot-password', [\App\Http\Controllers\API\Auth\PasswordResetLinkController::class, 'sendPasswordResetEmail'])
        ->middleware('guest');
    Route::controller(\App\Http\Controllers\API\V1\UserController::class)
    //->middleware('auth:api')
    ->group(function (){
        Route::get('users', 'index');
        Route::get('users/{user}', 'show');
        Route::post('register', 'store')->withoutMiddleware('auth:api');
        Route::put('users/{user}', 'update');
    });


    Route::controller(\App\Http\Controllers\API\V1\Patient\PatientController::class)
    ->group(function (){
        Route::get('patient', 'index')->name('patient.index');
        Route::get('patient/{patient}', 'show')->name('patient.show');
        Route::post('patient', 'store')->name('patient.store');
        Route::put('patient/{patient}', 'update')->name('patient.update');
    });

    //Households APIs
    Route::prefix('households')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Household\HouseholdFolderController::class)
            ->group(function() {
                Route::get('household-folders', 'index');
                Route::get('household-folders/{householdFolder}', 'show');
                Route::post('household-folders', 'store');
                Route::put('household-folders/{householdFolder}', 'update');
            });
    });

    //Patient Philhealth APIs
    Route::prefix('patient-philhealth')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientPhilhealthController::class)
            ->group(function() {
                Route::get('philhealth', 'index');
                Route::get('philhealth/{patientPhilhealth}', 'show');
                Route::post('philhealth', 'store');
                Route::put('philhealth/{patientPhilhealth}', 'update');
            });
    });

    //Patient Vaccines APIs
    Route::prefix('patient-vaccines')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientVaccineController::class)
        ->group(function() {
            Route::post('vaccines', 'store');
            Route::get('vaccines-records', 'index');
            Route::get('vaccines-records/{patientvaccine}', 'show');
            Route::post('vaccines/{id}', 'update');
            Route::delete('vaccines/{id}', 'destroy');
        });
    });

    //Patient Vitals APIs
    Route::prefix('patient-vitals')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientVitalsController::class)
            ->group(function() {
                Route::get('vitals', 'index');
                Route::get('vitals/{vitals}', 'show');
                Route::post('vitals', 'store');
                Route::put('vitals/{vitals}', 'update');
            });
    });

    //Childcare APIs
    Route::prefix('child-care')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Childcare\PatientCcdevController::class)
        ->group(function() {
            Route::post('cc-records', 'store');
            // Route::post('cc-records/{patient_ccdev_id}', 'update');
            Route::get('cc-records/{patientccdev}', 'show');
        });
        Route::controller(\App\Http\Controllers\API\V1\Childcare\ConsultCcdevServiceController::class)
        ->group(function() {
            Route::post('cc-services', 'store');
            Route::get('cc-services', 'index');
        });
        Route::controller(\App\Http\Controllers\API\V1\Childcare\ConsultCcdevBreastfedController::class)
        ->group(function() {
            Route::post('cc-breastfed', 'store');
            Route::get('cc-breastfed/{patientccdevbfed}', 'show');
        });

    });

    //Consultation APIs
    Route::prefix('consultation')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultController::class)
        ->group(function() {
            Route::post('cn-records', 'store');
            Route::post('cn-records/{id}', 'update');
            Route::get('cn-count', 'show');
            Route::get('cn-records', 'index');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesComplaintController::class)
        ->group(function() {
            Route::post('cn-complaint', 'store');
            // Route::get('cn-complaint/{consult_id}', 'show');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesInitialDxController::class)
        ->group(function() {
            Route::post('cn-idx', 'store');
            Route::delete('cn-idx/{id}', 'destroy');
            Route::get('cn-idx/{id}', 'show');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesFinalDxController::class)
        ->group(function() {
            Route::post('cn-fdx', 'store');
            Route::get('cn-fdx/{id}', 'show');
            Route::delete('cn-fdx/{id}', 'destroy');
        });
    });

    //Maternal Care APIs
    Route::prefix('maternal-care')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcController::class)
            ->group(function() {
                Route::get('mc-records', 'index');
                Route::get('mc-records/{mc}', 'show');
                //Route::post('mc-records', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcPreRegistrationController::class)
            ->group(function() {
                Route::get('mc-preregistrations/{preRegistration}', 'show');
                Route::post('mc-preregistrations', 'store');
                Route::put('mc-preregistrations/{preRegistration}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcPostRegistrationController::class)
            ->group(function() {
                Route::get('mc-postregistrations/{postRegistration}', 'show');
                Route::post('mc-postregistrations', 'store');
                Route::put('mc-postregistrations/{postRegistration}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcPrenatalController::class)
            ->group(function() {
                Route::get('mc-prenatal/{mcPrenatal}', 'show');
                Route::post('mc-prenatal', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcPostpartumController::class)
            ->group(function() {
                Route::get('mc-postpartum/{mcPostpartum}', 'show');
                Route::post('mc-postpartum', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcRiskController::class)
            ->group(function() {
                //Route::get('mc-risk-factors/{mcRisk}', 'show');
                Route::get('mc-risk-factors', 'index');
                Route::post('mc-risk-factors', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcServiceController::class)
            ->group(function() {
                Route::get('mc-services', 'index');
                Route::post('mc-services', 'store');
            });
    });

    Route::prefix('libraries')->group(function () {
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

    });

});
