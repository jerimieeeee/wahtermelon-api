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

Route::prefix('v1')->group(function () {
    Route::post('login', [\App\Http\Controllers\API\Auth\AuthenticationController::class, 'login']);
    Route::get('logout', [\App\Http\Controllers\API\Auth\AuthenticationController::class, 'logout'])->middleware('auth:api');
    Route::get('email/verify/{id}', [\App\Http\Controllers\API\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('email/resend', [\App\Http\Controllers\API\Auth\VerificationController::class, 'resend'])->name('verification.resend');
    Route::post('forgot-password', [\App\Http\Controllers\API\Auth\PasswordResetLinkController::class, 'sendPasswordResetEmail'])
        ->middleware('guest');
    Route::post('reset-password', [\App\Http\Controllers\API\Auth\ChangePasswordController::class, 'passwordResetProcess'])->middleware('guest');

    Route::controller(\App\Http\Controllers\API\V1\UserController::class)
        ->middleware('auth:api')
        ->group(function () {
            Route::get('users', 'index');
            Route::get('users/{user}', 'show');
            Route::post('register', 'store')->withoutMiddleware('auth:api');
            Route::put('users/{user}', 'update');
        });

    Route::controller(\App\Http\Controllers\API\V1\Patient\PatientController::class)
        ->middleware('auth:api')
        ->group(function () {
            Route::get('patient', 'index')->name('patient.index');
            Route::get('patient/{patient}', 'show')->name('patient.show');
            Route::post('patient', 'store')->name('patient.store');
            Route::put('patient/{patient}', 'update')->name('patient.update');
        });

    Route::controller(\App\Http\Controllers\API\V1\Patient\PatientImageController::class)
        ->middleware('auth:api')
        ->group(function () {
            Route::post('images', 'store')->name('images.store');
            Route::get('images/{id}', 'show')->name('images.show');
            Route::put('images/{id}', 'update')->name('images.update');
        });

    //Roles and Permissions
    Route::prefix('authorization')->group(function () {
        Route::controller(\App\Http\Controllers\API\Authorization\RoleController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('roles', 'addRole');
            });
    });

    //Households APIs
    Route::prefix('households')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Household\HouseholdFolderController::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('household-folders', 'index');
                    Route::get('household-folders/{householdFolder}', 'show');
                    Route::post('household-folders', 'store');
                    Route::put('household-folders/{householdFolder}', 'update');
                });
        Route::prefix('environmental')->group(function () {
            Route::controller(App\Http\Controllers\API\V1\Household\HouseholdEnvironmentalController::class)
                ->middleware(('auth:api'))
                ->group(function () {
                    Route::get('records', 'index');
                    Route::post('records', 'store');
                    Route::delete('records/{householdEnvironmental}', 'destroy');
                });
        });
    });

    //Patient Philhealth APIs
    Route::prefix('patient-philhealth')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientPhilhealthController::class)
            ->middleware('auth:api')
            ->group(function () {
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
            ->group(function () {
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
            ->group(function () {
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
            ->group(function () {
                Route::get('cc-records', 'index');
                Route::post('cc-records', 'store');
                Route::put('cc-records/{patient_id}', 'update');
                Route::get('cc-records/{patientccdev}', 'show');
            });
        Route::controller(\App\Http\Controllers\API\V1\Childcare\ConsultCcdevServiceController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('cc-services', 'store');
                Route::get('cc-services', 'index');
                Route::put('cc-services/{id}', 'update');
                Route::delete('cc-services/{id}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Childcare\ConsultCcdevBreastfedController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('cc-breastfed', 'store');
                Route::get('cc-breastfed/{patientccdevbfed}', 'show');
            });
    });

    //Consultation APIs
    Route::prefix('consultation')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('records', 'store');
                Route::put('records/{id}', 'update');
                // Route::get('cn-records', 'show');
                Route::get('count', 'show');
                Route::get('records', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesComplaintController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('complaint', 'store');
                // Route::get('cn-complaint/{consult_id}', 'show');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesInitialDxController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('initial-diagnosis', 'store');
                Route::delete('initial-diagnosis/{id}', 'destroy');
                Route::get('initial-diagnosis/{id}', 'show');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesFinalDxController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('final-diagnosis', 'store');
                Route::get('final-diagnosis/{id}', 'show');
                Route::delete('final-diagnosis/{id}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultStatsController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('stats', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::put('notes/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesPeController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('physical-exam', 'store');
                Route::post('physical-exam/{id}', 'show');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultPeRemarksController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('physical-exam-remarks', 'store');
                Route::put('physical-exam-remarks/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\Consultation\ConsultNotesManagementController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::post('management', 'store');
            });
    });

    //Maternal Care APIs
    Route::prefix('maternal-care')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('mc-records', 'index');
                Route::get('mc-records/{mc}', 'show');
                //Route::post('mc-records', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcPreRegistrationController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('mc-preregistrations/{preRegistration}', 'show');
                Route::post('mc-preregistrations', 'store');
                Route::put('mc-preregistrations/{preRegistration}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\PatientMcPostRegistrationController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('mc-postregistrations/{postRegistration}', 'show');
                Route::post('mc-postregistrations', 'store');
                Route::put('mc-postregistrations/{postRegistration}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcPrenatalController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('mc-prenatal/{mcPrenatal}', 'show');
                Route::post('mc-prenatal', 'store');
                Route::put('mc-prenatal/{mcPrenatal}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcPostpartumController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('mc-postpartum/{mcPostpartum}', 'show');
                Route::post('mc-postpartum', 'store');
                Route::put('mc-postpartum/{mcPostpartum}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcRiskController::class)
            ->middleware('auth:api')
            ->group(function () {
                //Route::get('mc-risk-factors/{mcRisk}', 'show');
                Route::get('mc-risk-factors', 'index');
                Route::post('mc-risk-factors', 'store');
                Route::put('mc-risk-factors/{mcRisk}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\MaternalCare\ConsultMcServiceController::class)
            ->middleware('auth:api')
            ->group(function () {
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
            ->group(function () {
                Route::get('risk-assessment', 'index');
//                Route::get('risk-strat/{riskStrat}', 'show');
                Route::post('risk-assessment', 'store');
                Route::put('risk-assessment/{ncdRisk}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningBloodGlucoseController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('risk-screening-blood-glucose', 'index');
                Route::post('risk-screening-blood-glucose', 'store');
                Route::put('risk-screening-blood-glucose/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningBloodLipidController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('risk-screening-blood-lipid', 'index');
                Route::post('risk-screening-blood-lipid', 'store');
                Route::put('risk-screening-blood-lipid/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningUrineKetonesController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('risk-screening-urine-ketones', 'index');
                Route::post('risk-screening-urine-ketones', 'store');
                Route::put('risk-screening-urine-ketones/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskScreeningUrineProteinController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('risk-screening-urine-protein', 'index');
                Route::post('risk-screening-urine-protein', 'store');
                Route::put('risk-screening-urine-protein/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskQuestionnaireController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('risk-questionnaire', 'index');
                Route::post('risk-questionnaire', 'store');
                Route::put('risk-questionnaire/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\PatientNcdRecordController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('patient-record', 'index');
                Route::post('patient-record', 'store');
                // Route::put('risk-questionnaire/{id}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\NCD\ConsultNcdRiskStratificationController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('risk-stratification', 'index');
            });
    });
    //Medicine
    Route::prefix('medicine')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Medicine\MedicinePrescriptionController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('prescriptions', 'index');
                Route::post('prescriptions', 'store');
                Route::put('prescriptions/{prescription}', 'update');
                Route::delete('prescriptions/{prescription}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Medicine\MedicineDispensingController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('dispensing', 'index');
                Route::post('dispensing', 'store');
                Route::put('dispensing/{dispensing}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\Medicine\MedicineListController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('list', 'index');
                Route::post('list', 'store');
                Route::put('list/{medicineList}', 'update');
                Route::delete('list/{medicineList}', 'destroy');
            });
    });

    //Konsulta
    Route::prefix('konsulta')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Konsulta\KonsultaController::class)
            ->middleware('auth:api')
            ->group(function () {
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
                Route::post('upload-registration', 'uploadRegistrationList');
            });
        Route::controller(\App\Http\Controllers\API\V1\Konsulta\KonsultaRegistrationListController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('registration-lists', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\Konsulta\KonsultaImportController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('imported-xml', 'index');
            });
    });

    //Settings
    Route::prefix('settings')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\PhilHealth\PhilhealthCredentialController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('philhealth-credentials', 'index');
                Route::post('philhealth-credentials', 'store');
                //Route::put('dispensing/{dispensing}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\Barangay\SettingsCatchmentBarangayController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('catchment-barangay', 'index');
                Route::post('catchment-barangay', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\Barangay\SettingsBhsController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('bhs', 'index');
                Route::post('bhs', 'store');
                Route::put('bhs/{bhs}', 'update');
            });
    });

    //Patient Medical History APIs
    Route::prefix('patient-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientHistoryController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('history', 'index');
                Route::get('history/{patientHistory}', 'show');
                Route::post('history', 'store');
            });
    });

    //Patient Social History APIs
    Route::prefix('patient-social-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientSocialHistoryController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('history', 'index');
                Route::get('history/{patientSocialHistory}', 'show');
                Route::post('history', 'store');
            });
    });

    //Consult Laboratory
    Route::prefix('laboratory')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratories', 'index');
                Route::post('consult-laboratories', 'store');
                Route::put('consult-laboratories/{laboratory}', 'update');
                Route::delete('consult-laboratories/{laboratory}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryCbcController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-cbc', 'index');
                Route::post('consult-laboratory-cbc', 'store');
                Route::put('consult-laboratory-cbc/{cbc}', 'update');
                Route::delete('consult-laboratory-cbc/{cbc}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryCreatinineController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-creatinine', 'index');
                Route::post('consult-laboratory-creatinine', 'store');
                Route::put('consult-laboratory-creatinine/{creatinine}', 'update');
                Route::delete('consult-laboratory-creatinine/{creatinine}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryChestXrayController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-chestxray', 'index');
                Route::post('consult-laboratory-chestxray', 'store');
                Route::put('consult-laboratory-chestxray/{chestxray}', 'update');
                Route::delete('consult-laboratory-chestxray/{chestxray}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryEcgController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-ecg', 'index');
                Route::post('consult-laboratory-ecg', 'store');
                Route::put('consult-laboratory-ecg/{ecg}', 'update');
                Route::delete('consult-laboratory-ecg/{ecg}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryFbsController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-fbs', 'index');
                Route::post('consult-laboratory-fbs', 'store');
                Route::put('consult-laboratory-fbs/{fbs}', 'update');
                Route::delete('consult-laboratory-fbs/{fbs}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryRbsController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-rbs', 'index');
                Route::post('consult-laboratory-rbs', 'store');
                Route::put('consult-laboratory-rbs/{rbs}', 'update');
                Route::delete('consult-laboratory-rbs/{rbs}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryHba1cController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-hba1c', 'index');
                Route::post('consult-laboratory-hba1c', 'store');
                Route::put('consult-laboratory-hba1c/{hba1c}', 'update');
                Route::delete('consult-laboratory-hba1c/{hba1c}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryPapsmearController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-papsmear', 'index');
                Route::post('consult-laboratory-papsmear', 'store');
                Route::put('consult-laboratory-papsmear/{papsmear}', 'update');
                Route::delete('consult-laboratory-papsmear/{papsmear}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryPpdController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-ppd', 'index');
                Route::post('consult-laboratory-ppd', 'store');
                Route::put('consult-laboratory-ppd/{ppd}', 'update');
                Route::delete('consult-laboratory-ppd/{ppd}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratorySputumController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-sputum', 'index');
                Route::post('consult-laboratory-sputum', 'store');
                Route::put('consult-laboratory-sputum/{sputum}', 'update');
                Route::delete('consult-laboratory-sputum/{sputum}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryFecalysisController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-fecalysis', 'index');
                Route::post('consult-laboratory-fecalysis', 'store');
                Route::put('consult-laboratory-fecalysis/{fecalysis}', 'update');
                Route::delete('consult-laboratory-fecalysis/{fecalysis}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryLipidProfileController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-lipid-profile', 'index');
                Route::post('consult-laboratory-lipid-profile', 'store');
                Route::put('consult-laboratory-lipid-profile/{lipidProfile}', 'update');
                Route::delete('consult-laboratory-lipid-profile/{lipidProfile}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryUrinalysisController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-urinalysis', 'index');
                Route::post('consult-laboratory-urinalysis', 'store');
                Route::put('consult-laboratory-urinalysis/{urinalysis}', 'update');
                Route::delete('consult-laboratory-urinalysis/{urinalysis}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryOralGlucoseController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-oral-glucose', 'index');
                Route::post('consult-laboratory-oral-glucose', 'store');
                Route::put('consult-laboratory-oral-glucose/{oralGlucose}', 'update');
                Route::delete('consult-laboratory-oral-glucose/{oralGlucose}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryFecalOccultController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-fecal-occult', 'index');
                Route::post('consult-laboratory-fecal-occult', 'store');
                Route::put('consult-laboratory-fecal-occult/{fecalOccult}', 'update');
                Route::delete('consult-laboratory-fecal-occult/{fecalOccult}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryGramStainController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-gram-stain', 'index');
                Route::post('consult-laboratory-gram-stain', 'store');
                Route::put('consult-laboratory-gram-stain/{gramStain}', 'update');
                Route::delete('consult-laboratory-gram-stain/{gramStain}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryMicroscopyController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-microscopy', 'index');
                Route::post('consult-laboratory-microscopy', 'store');
                Route::put('consult-laboratory-microscopy/{microscopy}', 'update');
                Route::delete('consult-laboratory-microscopy/{microscopy}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryUltrasoundController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-ultrasound', 'index');
                Route::post('consult-laboratory-ultrasound', 'store');
                Route::put('consult-laboratory-ultrasound/{ultrasound}', 'update');
                Route::delete('consult-laboratory-ultrasound/{ultrasound}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryGeneXpertController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-geneXpert', 'index');
                Route::post('consult-laboratory-geneXpert', 'store');
                Route::put('consult-laboratory-geneXpert/{geneXpert}', 'update');
                Route::delete('consult-laboratory-geneXpert/{geneXpert}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryDengueRdtController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-dengue', 'index');
                Route::post('consult-laboratory-dengue', 'store');
                Route::put('consult-laboratory-dengue/{dengue}', 'update');
                Route::delete('consult-laboratory-dengueRdt/{dengue}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratorySerologyController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-serology', 'index');
                Route::post('consult-laboratory-serology', 'store');
                Route::put('consult-laboratory-serology/{serology}', 'update');
                Route::delete('consult-laboratory-serology/{serology}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryBiopsyController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-biopsy', 'index');
                Route::post('consult-laboratory-biopsy', 'store');
                Route::put('consult-laboratory-biopsy/{biopsy}', 'update');
                Route::delete('consult-laboratory-biopsy/{biopsy}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryMalariaRdtController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-malaria', 'index');
                Route::post('consult-laboratory-malaria', 'store');
                Route::put('consult-laboratory-malaria/{malaria}', 'update');
                Route::delete('consult-laboratory-malaria/{malaria}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratorySkinSlitSmearController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-skin-slit', 'index');
                Route::post('consult-laboratory-skin-slit', 'store');
                Route::put('consult-laboratory-skin-slit/{skinSleat}', 'update');
                Route::delete('consult-laboratory-skin-slit/{skinSleat}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryWetSmearController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-wet-smear', 'index');
                Route::post('consult-laboratory-wet-smear', 'store');
                Route::put('consult-laboratory-wet-smear/{wetSmear}', 'update');
                Route::delete('consult-laboratory-wet-smear/{wetSmear}', 'destroy');
            });

        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryCervicalCancerController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-cervical-cancer', 'index');
                Route::post('consult-laboratory-cervical-cancer', 'store');
                Route::put('consult-laboratory-cervical-cancer/{cancerScreening}', 'update');
                Route::delete('consult-laboratory-cervical-cancer/{cancerScreening}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryBloodChemistryController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-blood-chemistry', 'index');
                Route::post('consult-laboratory-blood-chemistry', 'store');
                Route::put('consult-laboratory-blood-chemistry/{blodchemistry}', 'update');
                Route::delete('consult-laboratory-blood-chemistry/{blodchemistry}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryHematologyController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-hematology', 'index');
                Route::post('consult-laboratory-hematology', 'store');
                Route::put('consult-laboratory-hematology/{hematology}', 'update');
                Route::delete('consult-laboratory-hematology/{hematology}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratorySyphilisController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-syphilis', 'index');
                Route::post('consult-laboratory-syphilis', 'store');
                Route::put('consult-laboratory-syphilis/{syphilis}', 'update');
                Route::delete('consult-laboratory-syphilis/{syphilis}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryPotassiumController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-potassium', 'index');
                Route::post('consult-laboratory-potassium', 'store');
                Route::put('consult-laboratory-potassium/{potassium}', 'update');
                Route::delete('consult-laboratory-potassium/{potassium}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\Laboratory\ConsultLaboratoryXrayController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('consult-laboratory-xray', 'index');
                Route::post('consult-laboratory-xray', 'store');
                Route::put('consult-laboratory-xray/{xray}', 'update');
                Route::delete('consult-laboratory-xray/{xray}', 'destroy');
            });
    });

    //Patient Menstrual History APIs
    Route::prefix('patient-menstrual-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientMenstrualHistoryController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('history', 'index');
                Route::get('history/{patientMenstrualHistory}', 'show');
                Route::post('history', 'store');
            });
    });

    //Patient Surgical History APIs
    Route::prefix('patient-surgical-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientSurgicalHistoryController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('history', 'index');
                Route::post('history', 'store');
                Route::delete('history/{patientSurgicalHistory}', 'destroy');
            });
    });

    //Patient Pregnancy History APIs
    Route::prefix('patient-pregnancy-history')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Patient\PatientPregnancyHistoryController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('history', 'index');
                Route::post('history', 'store');
                Route::get('history/{patientPregnancyHistory}', 'show');
            });
    });

    //Reports 2018
    Route::prefix('reports-2018')->group(function () {
        Route::prefix('child-care')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\ChildCareReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('m1', 'index');
                });
        });
        Route::prefix('maternal-care')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\MaternalCareReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('m1', 'index');
                });
        });
        Route::prefix('tb-dots')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\TBDotsReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('m1', 'index');
                });
        });
        Route::prefix('morbidity')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\MorbidityReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('report', 'index');
                });
        });
        Route::prefix('user')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\UserStats\UserStatsController::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('patient-registered', 'index');
                });
        });
        Route::prefix('household-profiling')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\Household\HouseholdProfilingReportController::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('report', 'index');
                });
        });
        Route::prefix('family-planning')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\FamilyPlanningReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('m1', 'index');
                });
        });
        Route::prefix('daily-service')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\General\DailyServiceReportController::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('report', 'index');
                });
        });
        Route::prefix('notifiable')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\DOH\NotifiableWeeklyReportController::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('weekly', 'index');
                });
        });
        Route::prefix('ncd')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\NcdReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('m1', 'index');
                });
        });
        Route::prefix('household-environmental')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\HouseholdEnvironmentalReport2018::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('m1', 'index');
                });
        });
        Route::prefix('animal-bite')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\AnimalBite\AnimalBiteReportController::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('report', 'index');
                });
        });
        Route::prefix('fp-namelist')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\FHSIS2018\FamilyPlanningNameListReport2018Controller::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('name-list', 'index');
                });
        });
        Route::prefix('pending-fdx')->group(function () {
            Route::controller(\App\Http\Controllers\API\V1\Reports\General\PendingFinalDiagnosisReportController::class)
                ->middleware('auth:api')
                ->group(function () {
                    Route::get('report', 'index');
                });
        });
    });

    Route::prefix('tbdots')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\TBDots\TBLibrariesController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('tb-libraries', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\TBDots\TBLibrariesCaseHoldingController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('tb-libraries-caseholding', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\TBDots\PatientTbHistoryController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-tb-history', 'index');
                Route::post('patient-tb-history', 'store');
                Route::get('patient-tb-history/{patientTbHistory}', 'show');
                Route::put('patient-tb-history/{patientTbHistory}', 'update');
                Route::delete('patient-tb-history/{patientTbHistory}', 'destroy');
            });
        Route::controller(\App\Http\Controllers\API\V1\TBDots\PatientTbCaseFindingController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-tb-casefinding', 'index');
                Route::post('patient-tb-casefinding', 'store');
                Route::get('patient-tb-casefinding/{patientTbCaseFinding}', 'show');
                Route::put('patient-tb-casefinding/{patientTbCaseFinding}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\TBDots\PatientTbSymptomController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-tb-symptom', 'index');
                Route::post('patient-tb-symptom', 'store');
                Route::get('patient-tb-symptom/{patientTbSymptom}', 'show');
                Route::put('patient-tb-symptom/{patientTbSymptom}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\TBDots\PatientTbPeController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-tb-pe', 'index');
                Route::post('patient-tb-pe', 'store');
                Route::get('patient-tb-pe/{patientTbPe}', 'show');
                Route::put('patient-tb-pe/{patientTbPe}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\TBDots\PatientTbController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-tb', 'index');
                Route::post('patient-tb', 'store');
                Route::get('patient-tb/{patientTb}', 'show');
                Route::put('patient-tb/{patientTb}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\TBDots\PatientTbCaseHoldingController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-tb-caseholding', 'index');
                Route::post('patient-tb-caseholding', 'store');
                Route::get('patient-tb-caseholding/{patientTb}', 'show');
                Route::put('patient-tb-caseholding/{patientTb}', 'update');
            });
    });

    //Appointment
    Route::prefix('appointment')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Appointment\AppointmentController::class)
            ->middleware('auth:api')
            ->group(function () {
                Route::get('schedule', 'index');
                Route::post('schedule', 'store');
            });
    });

    //Gender Based Violence
    Route::prefix('gender-based-violence')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv', 'index');
                Route::post('patient-gbv', 'store');
                Route::put('patient-gbv/{patientGbv}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvFamilyCompositionController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-family-composition', 'index');
                Route::post('patient-gbv-family-composition', 'store');
                Route::put('patient-gbv-family-composition/{patientGbvFamilyComposition}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvNeglectController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-neglect', 'index');
                Route::post('patient-gbv-neglect', 'store');
                Route::put('patient-gbv-neglect/{patientGbvNeglect}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvComplaintController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-complaint', 'index');
                Route::post('patient-gbv-complaint', 'store');
                Route::put('patient-gbv-complaint/{patientGbvComplaint}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvBehaviorController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-behavior', 'index');
                Route::post('patient-gbv-behavior', 'store');
                Route::put('patient-gbv-behavior/{$patientGbvBehavior}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvReferralController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-referral', 'index');
                Route::post('patient-gbv-referral', 'store');
                Route::put('patient-gbv-referral/{patientGbvReferral}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvInterviewController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-interview', 'index');
                Route::post('patient-gbv-interview', 'store');
                Route::put('patient-gbv-interview/{patientGbvInterview}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvInterviewPerpetratorController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-perpetrator', 'index');
                Route::post('patient-gbv-perpetrator', 'store');
                Route::put('patient-gbv-perpetrator/{patientGbvInterviewPerpetrator}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvInterviewSexualAbuseController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-sexual-abuse', 'index');
                Route::post('patient-gbv-sexual-abuse', 'store');
                Route::put('patient-gbv-sexual-abuse/{patientGbvInterviewSexualAbuse}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvInterviewPhysicalAbuseController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-physical-abuse', 'index');
                Route::post('patient-gbv-physical-abuse', 'store');
                Route::put('patient-gbv-physical-abuse/{patientGbvInterviewPhysicalAbuse}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvInterviewNeglectAbuseController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-neglect-abuse', 'index');
                Route::post('patient-gbv-neglect-abuse', 'store');
                Route::put('patient-gbv-neglect-abuse/{patientGbvInterviewNeglectAbuse}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvEmotionalAbuseController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-emotional-abuse', 'index');
                Route::post('patient-gbv-emotional-abuse', 'store');
                Route::put('patient-gbv-emotional-abuse/{patientGbvEmotionalAbuse}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvInterviewSummaryController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-interview-summary', 'index');
                Route::post('patient-gbv-interview-summary', 'store');
                Route::put('patient-gbv-interview-summary/{patientGbvInterviewSummary}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvInterviewDevScreeningController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-interview-dev-screening', 'index');
                Route::post('patient-gbv-interview-dev-screening', 'store');
                Route::put('patient-gbv-interview-dev-screening/{patientGbvInterviewDevScreening}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvConfController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-conference', 'index');
                Route::post('patient-gbv-conference', 'store');
                Route::put('patient-gbv-conference/{patientGbvConf}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvConfInviteController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-conference-invite', 'index');
                Route::post('patient-gbv-conference-invite', 'store');
                Route::put('patient-gbv-conference-invite/{patientGbvConfInvite}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvConfConcernController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-conference-concern', 'index');
                Route::post('patient-gbv-conference-concern', 'store');
                Route::put('patient-gbv-conference-concern/{patientGbvConfConcern}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\patientGbvConfMitigatingFactorController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-conference-mitigating-factor', 'index');
                Route::post('patient-gbv-conference-mitigating-factor', 'store');
                Route::put('patient-gbv-conference-mitigating-factor/{patientGbvConfMitigatingFactor}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvConRecommendationController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-conference-recommendation', 'index');
                Route::post('patient-gbv-conference-recommendation', 'store');
                Route::put('patient-gbv-conference-recommendation/{patientGbvConfRecommendation}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvPsychController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-psych', 'index');
                Route::post('patient-gbv-psych', 'store');
                Route::put('patient-gbv-psych/{patientGbvPsych}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvSocialWorkController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-social-work', 'index');
                Route::post('patient-gbv-social-work', 'store');
                Route::put('patient-gbv-social-work/{patientGbvSocialWork}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvPlacementController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-placement', 'index');
                Route::post('patient-gbv-placement', 'store');
                Route::put('patient-gbv-placement/{patientGbvPlacement}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvIntakeController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-intake', 'index');
                Route::post('patient-gbv-intake', 'store');
                Route::put('patient-gbv-intake/{patientGbvIntake}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvLegalCaseController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-legal', 'index');
                Route::post('patient-gbv-legal', 'store');
                Route::put('patient-gbv-legal/{patientGbvLegalCase}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvLegalVisitController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-legal-visit', 'index');
                Route::post('patient-gbv-legal-visit', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvConsultController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-consult', 'index');
                Route::post('patient-gbv-consult', 'store');
                // Route::put('patient-gbv-consult/{patientGbvLegalCase}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvConsultVisitController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-consult-visit', 'index');
                Route::post('patient-gbv-consult-visit', 'store');
                // Route::put('patient-gbv-consult/{patientGbvLegalCase}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvUserController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-user', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvSymptomsAnogenitalController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-symptoms-anogenital', 'index');
                Route::post('patient-gbv-symptoms-anogenital', 'store');
                Route::put('patient-gbv-symptoms/{patientGbvSymptomsAnogenital}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvSymptomsCorporalController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-symptoms-corporal', 'index');
                Route::post('patient-gbv-symptoms-corporal', 'store');
                // Route::put('patient-gbv-symptoms/{patientGbvSymptomsCorporal}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvSymptomsBehavioralController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-symptoms-behavioral', 'index');
                Route::post('patient-gbv-symptoms-behavioral', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvPdfUploadController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-file-upload', 'index');
                Route::post('patient-gbv-file-upload', 'store');
                Route::get('patient-gbv-file-upload/{gbvPdfUpload}', 'show');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvListController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-list', 'index');
            });
        Route::controller(\App\Http\Controllers\API\V1\GenderBasedViolence\PatientGbvMedicalHistoryController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-gbv-medical-history', 'index');
                Route::post('patient-gbv-medical-history', 'store');
                Route::put('patient-gbv-medical-history/{patientGbvMedicalHistory}', 'update');
            });
    });

    //eClaims
    Route::prefix('eclaims')->group(function () {
        Route::controller(\App\Http\Controllers\API\V1\Eclaims\EclaimsSyncController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::post('check-ws', 'checkWS');
                Route::post('case-rate', 'SearchCaseRate');
                Route::post('get-member-pin', 'GetMemberPIN');
                Route::post('search-hospital', 'SearchHospital');
                Route::post('search-employer', 'SearchEmployer');
                Route::post('get-doctor-pan', 'GetDoctorPAN');
                Route::post('get-claim-status', 'GetClaimStatus');
                Route::post('get-voucher-details', 'GetVoucherDetails');
                Route::post('check-claim-eligibility', 'isClaimEligible');
                Route::post('check-doctor-accredited', 'isDoctorAccredited');
                Route::post('upload-claim', 'eClaimsUpload');
                Route::post('get-claims-map', 'getUploadedClaimsMap');
                Route::post('add-required-docs', 'addRequiredDocument');
            });
        Route::controller(\App\Http\Controllers\API\V1\Eclaims\EclaimsCaserateListController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('eclaims-caserate', 'index');
                Route::post('eclaims-caserate', 'store');
                Route::put('eclaims-caserate/{eclaimsCaserate}', 'update');
            });
        Route::controller(\App\Http\Controllers\API\V1\Eclaims\EclaimsXmlController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::post('eclaims-xml', 'createXml');
                // Route::post('eclaims-xml', 'store');
            });
        Route::controller(\App\Http\Controllers\API\V1\Eclaims\EclaimsUploadController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('eclaims-upload', 'index');
                Route::post('eclaims-upload', 'store');
                Route::post('create-enc-xml', 'createEncXml');
                Route::post('create-required-xml', 'createRequiredXml');
            });
        Route::controller(\App\Http\Controllers\API\V1\Eclaims\EclaimsUploadDocumentController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('eclaims-doc', 'index');
                Route::post('eclaims-doc', 'store');
                Route::delete('eclaims-doc/{eclaimsDoc}', 'destroy');
                // Route::post('eclaims-xml', 'store');
            });

    });

    Route::prefix('gbv-report')->group(function () {
        Route::controller(App\Http\Controllers\API\V1\Reports\GenderBasedViolence\GenderBasedViolenceReportController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('catalyst-report', 'index');
            });
    });

    Route::prefix('family-planning')->group(function () {
        Route::controller(App\Http\Controllers\API\V1\FamilyPlanning\PatientFpController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('fp-records', 'index');
                Route::post('fp-records', 'store');
                Route::get('fp-records/{patientFp}', 'show');
            });
        Route::controller(App\Http\Controllers\API\V1\FamilyPlanning\PatientFpHistoryController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::post('fp-history', 'store');
            });
        Route::controller(App\Http\Controllers\API\V1\FamilyPlanning\PatientFpPhysicalExamController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::post('fp-physical-exam', 'store');
            });
        Route::controller(App\Http\Controllers\API\V1\FamilyPlanning\PatientFpPelvicExamController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::post('fp-pelvic-exam', 'store');
            });
        Route::controller(App\Http\Controllers\API\V1\FamilyPlanning\PatientFpMethodController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::post('fp-method', 'store');
                Route::put('fp-method/{patientFpMethod}', 'update');
                Route::get('fp-method', 'index');
                Route::delete('fp-method/{patientFpMethod}', 'destroy');
            });
        Route::controller(App\Http\Controllers\API\V1\FamilyPlanning\PatientFpChartController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::post('fp-chart', 'store');
                Route::get('fp-chart', 'index');
                Route::put('fp-chart/{patientFpChart}', 'update');
                Route::delete('fp-chart/{patientFpChart}', 'destroy');
            });
    });

    Route::prefix('animal-bite')->group(function () {
        Route::controller(App\Http\Controllers\API\V1\AnimalBite\PatientAbController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-ab', 'index');
                Route::post('patient-ab', 'store');
                Route::get('patient-ab/{patientAb}', 'show');
                Route::put('patient-ab/{patientAb}', 'update');
            });
        Route::controller(App\Http\Controllers\API\V1\AnimalBite\PatientAbExposureController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-ab-exposure', 'index');
                Route::put('patient-ab-exposure/{patientAbExposure}', 'update');
            });
        Route::controller(App\Http\Controllers\API\V1\AnimalBite\PatientAbPreExposureController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-ab-pre-exposure', 'index');
                Route::post('patient-ab-pre-exposure', 'store');
                Route::put('patient-ab-pre-exposure/{patientAbPreExposure}', 'update');
                Route::delete('patient-ab-pre-exposure/{patientAbPreExposure}', 'destroy');
            });
        Route::controller(App\Http\Controllers\API\V1\AnimalBite\PatientAbPostExposureController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('patient-ab-post-exposure', 'index');
                Route::post('patient-ab-post-exposure', 'store');
            });
    });

    Route::prefix('dental')->group(function () {
        Route::controller(App\Http\Controllers\API\V1\Dental\DentalMedicalSocialsController::class)
            ->middleware(('auth:api'))
            ->group(function () {
                Route::get('medical-socials', 'index');
                Route::post('medical-socials', 'store');
                Route::get('medical-socials/{dentalMedicalSocials}', 'show');
                Route::put('medical-socials/{dentalMedicalSocials}', 'update');
            });
    });
});
