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
    Route::post('reset-password', [\App\Http\Controllers\API\Auth\ChangePasswordController::class, 'passwordResetProcess'])->middleware('guest');

    Route::controller(\App\Http\Controllers\API\V1\UserController::class)
    ->middleware('auth:api')
    ->group(function (){
        Route::get('users', 'index');
        Route::get('users/{user}', 'show');
        Route::post('register', 'store')->withoutMiddleware('auth:api');
        Route::put('users/{user}', 'update');
    });


    Route::controller(\App\Http\Controllers\API\V1\Patient\PatientController::class)
    ->middleware('auth:api')
    ->group(function (){
        Route::get('patient', 'index')->name('patient.index');
        Route::get('patient/{patient}', 'show')->name('patient.show');
        Route::post('patient', 'store')->name('patient.store');
        Route::put('patient/{patient}', 'update')->name('patient.update');
    });

    //Households APIs
    Route::prefix('households')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Household\HouseholdFolderController::class)
            ->middleware('auth:api')
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
            ->middleware('auth:api')
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
            ->middleware('auth:api')
            ->group(function() {
            Route::post('vaccines', 'store');
            Route::get('vaccines-records', 'index');
            Route::get('vaccines-records/{patientvaccine}', 'show');
            Route::put('vaccines/{id}', 'update');
            Route::delete('vaccines/{id}', 'destroy');
        });
    });

    //Patient Vitals APIs
    Route::prefix('patient-vitals')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientVitalsController::class)
            ->middleware('auth:api')
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
            ->middleware('auth:api')
            ->group(function() {
            Route::post('cc-records', 'store');
            Route::put('cc-records/{patient_id}', 'update');
            Route::get('cc-records/{patientccdev}', 'show');
        });
        Route::controller(\App\Http\Controllers\API\V1\Childcare\ConsultCcdevServiceController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::post('cc-services', 'store');
            Route::get('cc-services', 'index');
            Route::put('cc-services/{id}', 'update');
            Route::delete('cc-services/{id}', 'destroy');
        });
        Route::controller(\App\Http\Controllers\API\V1\Childcare\ConsultCcdevBreastfedController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::post('cc-breastfed', 'store');
            Route::get('cc-breastfed/{patientccdevbfed}', 'show');
        });
    });

    //Consultation APIs
    Route::prefix('consultation')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::post('records', 'store');
            Route::put('records/{id}', 'update');
            // Route::get('cn-records', 'show');
            Route::get('count', 'show');
            Route::get('records', 'index');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesComplaintController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::post('complaint', 'store');
            // Route::get('cn-complaint/{consult_id}', 'show');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesInitialDxController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::post('initial-diagnosis', 'store');
            Route::delete('initial-diagnosis/{id}', 'destroy');
            Route::get('initial-diagnosis/{id}', 'show');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesFinalDxController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::post('final-diagnosis', 'store');
            Route::get('final-diagnosis/{id}', 'show');
            Route::delete('final-diagnosis/{id}', 'destroy');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultStatsController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::get('stats', 'index');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesController::class)
            ->middleware('auth:api')
            ->group(function() {
            Route::put('notes/{id}', 'update');
         });
         Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesPeController::class)
         ->middleware('auth:api')
         ->group(function() {
         Route::post('physical-exam', 'store');
         Route::post('physical-exam/{id}', 'show');
        });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultPeRemarksController::class)
        ->middleware('auth:api')
        ->group(function() {
        Route::post('physical-exam-remarks', 'store');
        Route::put('physical-exam-remarks/{id}', 'update');
        });
    });

    //Maternal Care APIs
    Route::prefix('maternal-care')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('mc-records', 'index');
                Route::get('mc-records/{mc}', 'show');
                //Route::post('mc-records', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcPreRegistrationController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('mc-preregistrations/{preRegistration}', 'show');
                Route::post('mc-preregistrations', 'store');
                Route::put('mc-preregistrations/{preRegistration}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcPostRegistrationController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('mc-postregistrations/{postRegistration}', 'show');
                Route::post('mc-postregistrations', 'store');
                Route::put('mc-postregistrations/{postRegistration}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcPrenatalController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('mc-prenatal/{mcPrenatal}', 'show');
                Route::post('mc-prenatal', 'store');
                Route::put('mc-prenatal/{mcPrenatal}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcPostpartumController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('mc-postpartum/{mcPostpartum}', 'show');
                Route::post('mc-postpartum', 'store');
                Route::put('mc-postpartum/{mcPostpartum}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcRiskController::class)
            ->middleware('auth:api')
            ->group(function() {
                //Route::get('mc-risk-factors/{mcRisk}', 'show');
                Route::get('mc-risk-factors', 'index');
                Route::post('mc-risk-factors', 'store');
                Route::put('mc-risk-factors/{mcRisk}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcServiceController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('mc-services', 'index');
                Route::post('mc-services', 'store');
                Route::put('mc-services/{mcService}', 'update');
            });
    });

    //Non-Communicable Disease APIs
    Route::prefix('non-communicable-disease')->group(function () {
        // Route::controller(\App\Http\Controllers\API\V1\NCD\PatientNcdController::class)
        //     ->middleware('auth:api')
        //     ->group(function() {
        //         // Route::get('records', 'index');
        //         // Route::post('records', 'store');
        //         Route::put('records/{patientNcd}', 'update');
        // });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskAssessmentController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('risk-assessment', 'index');
                Route::post('risk-assessment', 'store');
                Route::put('risk-assessment/{ncdRisk}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningBloodGlucoseController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('risk-screening-blood-glucose', 'index');
                Route::post('risk-screening-blood-glucose', 'store');
                Route::put('risk-screening-blood-glucose/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningBloodLipidController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('risk-screening-blood-lipid', 'index');
                Route::post('risk-screening-blood-lipid', 'store');
                Route::put('risk-screening-blood-lipid/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningUrineKetonesController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('risk-screening-urine-ketones', 'index');
                Route::post('risk-screening-urine-ketones', 'store');
                Route::put('risk-screening-urine-ketones/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningUrineProteinController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('risk-screening-urine-protein', 'index');
                Route::post('risk-screening-urine-protein', 'store');
                Route::put('risk-screening-urine-protein/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskQuestionnaireController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('risk-questionnaire', 'index');
                Route::post('risk-questionnaire', 'store');
                Route::put('risk-questionnaire/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\PatientNcdRecordController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('patient-record', 'index');
                Route::post('patient-record', 'store');
                // Route::put('risk-questionnaire/{id}', 'update');
            });
        });
    //Medicine
    Route::prefix('medicine')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Medicine\MedicinePrescriptionController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('prescriptions', 'index');
                Route::post('prescriptions', 'store');
                Route::put('prescriptions/{prescription}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\Medicine\MedicineDispensingController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('dispensing', 'index');
                Route::post('dispensing', 'store');
                Route::put('dispensing/{dispensing}', 'update');
            });
    });

    //Konsulta
    Route::prefix('konsulta')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Konsulta\KonsultaController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('get-token', 'getToken');
                Route::get('registration-list', 'extractRegistrationList');
                Route::get('check-registered', 'checkRegistered');
                Route::get('check-atc', 'checkATC');
            });
    });

    //Settings
    Route::prefix('settings')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\PhilHealth\PhilhealthCredentialController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('philhealth-credentials', 'index');
                Route::post('philhealth-credentials', 'store');
                //Route::put('dispensing/{dispensing}', 'update');
            });
    });

    //Patient Philhealth APIs
    Route::prefix('patient-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientHistoryController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('history', 'index');
                Route::get('history/{patientHistory}', 'show');
                Route::post('history', 'store');
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
    });

});
