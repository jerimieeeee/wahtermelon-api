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
    Route::get('logout', [\App\Http\Controllers\API\Auth\AuthenticationController::class, 'logout'])->middleware('auth:api');
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
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesManagementController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::post('management', 'store');
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
                Route::get('validate-report', 'validateReport');
                Route::get('validated-xml', 'validatedXml');
                Route::get('submit-xml', 'submitXml');
                Route::get('generate-data', 'generateDataForValidation');
                Route::get('download-xml', 'downloadXml');
                Route::post('upload-xml', 'uploadXml');
                Route::post('generate-age', 'getAge');
            });
        Route::controller(\App\Http\Controllers\API\V1\Konsulta\KonsultaRegistrationListController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('registration-lists', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\Konsulta\KonsultaImportController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('imported-xml', 'index');
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

    //Patient Medical History APIs
    Route::prefix('patient-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientHistoryController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('history', 'index');
                Route::get('history/{patientHistory}', 'show');
                Route::post('history', 'store');
             });
        });

    //Patient Social History APIs
    Route::prefix('patient-social-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientSocialHistoryController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('history', 'index');
                Route::get('history/{patientSocialHistory}', 'show');
                Route::post('history', 'store');
            });
        });

    //Consult Laboratory
    Route::prefix('laboratory')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratories', 'index');
                Route::post('consult-laboratories', 'store');
                Route::put('consult-laboratories/{laboratory}', 'update');
                Route::delete('consult-laboratories/{laboratory}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryCbcController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-cbc', 'index');
                Route::post('consult-laboratory-cbc', 'store');
                Route::put('consult-laboratory-cbc/{cbc}', 'update');
                Route::delete('consult-laboratory-cbc/{cbc}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryCreatinineController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-creatinine', 'index');
                Route::post('consult-laboratory-creatinine', 'store');
                Route::put('consult-laboratory-creatinine/{creatinine}', 'update');
                Route::delete('consult-laboratory-creatinine/{creatinine}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryChestXrayController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-chestxray', 'index');
                Route::post('consult-laboratory-chestxray', 'store');
                Route::put('consult-laboratory-chestxray/{chestxray}', 'update');
                Route::delete('consult-laboratory-chestxray/{chestxray}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryEcgController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-ecg', 'index');
                Route::post('consult-laboratory-ecg', 'store');
                Route::put('consult-laboratory-ecg/{ecg}', 'update');
                Route::delete('consult-laboratory-ecg/{ecg}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryFbsController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-fbs', 'index');
                Route::post('consult-laboratory-fbs', 'store');
                Route::put('consult-laboratory-fbs/{fbs}', 'update');
                Route::delete('consult-laboratory-fbs/{fbs}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryRbsController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-rbs', 'index');
                Route::post('consult-laboratory-rbs', 'store');
                Route::put('consult-laboratory-rbs/{rbs}', 'update');
                Route::delete('consult-laboratory-rbs/{rbs}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryHba1cController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-hba1c', 'index');
                Route::post('consult-laboratory-hba1c', 'store');
                Route::put('consult-laboratory-hba1c/{hba1c}', 'update');
                Route::delete('consult-laboratory-hba1c/{hba1c}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryPapsmearController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-papsmear', 'index');
                Route::post('consult-laboratory-papsmear', 'store');
                Route::put('consult-laboratory-papsmear/{papsmear}', 'update');
                Route::delete('consult-laboratory-papsmear/{papsmear}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryPpdController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-ppd', 'index');
                Route::post('consult-laboratory-ppd', 'store');
                Route::put('consult-laboratory-ppd/{ppd}', 'update');
                Route::delete('consult-laboratory-ppd/{ppd}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratorySputumController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-sputum', 'index');
                Route::post('consult-laboratory-sputum', 'store');
                Route::put('consult-laboratory-sputum/{sputum}', 'update');
                Route::delete('consult-laboratory-sputum/{sputum}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryFecalysisController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-fecalysis', 'index');
                Route::post('consult-laboratory-fecalysis', 'store');
                Route::put('consult-laboratory-fecalysis/{fecalysis}', 'update');
                Route::delete('consult-laboratory-fecalysis/{fecalysis}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryLipidProfileController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-lipid-profile', 'index');
                Route::post('consult-laboratory-lipid-profile', 'store');
                Route::put('consult-laboratory-lipid-profile/{lipidProfile}', 'update');
                Route::delete('consult-laboratory-lipid-profile/{lipidProfile}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryUrinalysisController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-urinalysis', 'index');
                Route::post('consult-laboratory-urinalysis', 'store');
                Route::put('consult-laboratory-urinalysis/{urinalysis}', 'update');
                Route::delete('consult-laboratory-urinalysis/{urinalysis}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryOralGlucoseController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-oral-glucose', 'index');
                Route::post('consult-laboratory-oral-glucose', 'store');
                Route::put('consult-laboratory-oral-glucose/{oralGlucose}', 'update');
                Route::delete('consult-laboratory-oral-glucose/{oralGlucose}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryFecalOccultController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-fecal-occult', 'index');
                Route::post('consult-laboratory-fecal-occult', 'store');
                Route::put('consult-laboratory-fecal-occult/{fecalOccult}', 'update');
                Route::delete('consult-laboratory-fecal-occult/{fecalOccult}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryGramStainController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-gram-stain', 'index');
                Route::post('consult-laboratory-gram-stain', 'store');
                Route::put('consult-laboratory-gram-stain/{gramStain}', 'update');
                Route::delete('consult-laboratory-gram-stain/{gramStain}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryMicroscopyController::class)
            ->middleware('auth:api')
            ->group(function() {
                Route::get('consult-laboratory-microscopy', 'index');
                Route::post('consult-laboratory-microscopy', 'store');
                Route::put('consult-laboratory-microscopy/{microscopy}', 'update');
                Route::delete('consult-laboratory-microscopy/{microscopy}', 'destroy');
            });
    });

    //Patient Menstrual History APIs
    Route::prefix('patient-menstrual-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientMenstrualHistoryController::class)
            ->middleware('auth:api')
             ->group(function() {
                Route::get('history', 'index');
                Route::get('history/{patientMenstrualHistory}', 'show');
                Route::post('history', 'store');
            });
    });

    //Patient Surgical History APIs
    Route::prefix('patient-surgical-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientSurgicalHistoryController::class)
            ->middleware('auth:api')
             ->group(function() {
                Route::get('history', 'index');
                Route::post('history', 'store');
                Route::delete('history/{patientSurgicalHistory}', 'destroy');
            });
    });

    //Patient Pregnancy History APIs
    Route::prefix('patient-pregnancy-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientPregnancyHistoryController::class)
            ->middleware('auth:api')
             ->group(function() {
                Route::get('history', 'index');
                Route::post('history', 'store');
                Route::get('history/{patientPregnancyHistory}', 'show');
            });
        });

    //Reports 2018
    Route::prefix('reports-2018')->group(function () {
        Route::prefix('child-care')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\ChildCareReport2018Controller::class)
                ->middleware('auth:api')
                 ->group(function() {
                    Route::get('m1', 'index');
            });
        });
        Route::prefix('maternal-care')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\MaternalCareReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function() {
                    Route::get('m1', 'index');
                });
        });
    });


});
