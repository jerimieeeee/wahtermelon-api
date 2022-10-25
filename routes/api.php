<?php

use GuzzleHttp\Psr7\Request;
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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function (){
    Route::post('login', [\App\Http\Controllers\API\Auth\AuthenticationController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\API\V1\UserController::class, 'store']);

    Route::get('patient', [\App\Http\Controllers\API\V1\Patient\PatientController::class, 'index'])->name('patient.index');
    Route::get('patient/{patient}', [\App\Http\Controllers\API\V1\Patient\PatientController::class, 'show'])->name('patient.show');
    Route::post('patient', [\App\Http\Controllers\API\V1\Patient\PatientController::class, 'store'])->name('patient.store');

    //Patient Vaccines API
    Route::post('patient-vaccine', [\App\Http\Controllers\API\V1\Patient\PatientVaccineController::class, 'store']);

    //Childcare APIs
    Route::post('childcare-patient', [\App\Http\Controllers\API\V1\Childcare\PatientCcdevController::class, 'store']);
    Route::get('childcare-patient/{patient_ccdev_id}', [\App\Http\Controllers\API\V1\Childcare\PatientCcdevController::class, 'show'])->name('childcare-patient.show');

    Route::post('childcare-consult', [\App\Http\Controllers\API\V1\Childcare\ConsultCcdevController::class, 'store']);
    Route::get('childcare-consult/{consultccdev}', [\App\Http\Controllers\API\V1\Childcare\ConsultCcdevController::class, 'show'])->name('childcare-consult.show');

    Route::post('childcare-breastfed', [\App\Http\Controllers\API\V1\Childcare\ConsultCcdevBreastfedController::class, 'store']);
    Route::get('childcare-breastfed/{consultccdevbfed}', [\App\Http\Controllers\API\V1\Childcare\ConsultCcdevBreastfedController::class, 'show'])->name('childcare-breastfed.show');

    //Consultation APIs
    // Route::post('consult', [\App\Http\Controllers\API\V1\Consultation\ConsultController::class, 'store']);
    // Route::post('complaint', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesComplaintController::class, 'store']);
    // Route::post('consult-idx', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesInitialDxController::class, 'store']);
    // Route::post('consult-fdx', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesFinalDxController::class, 'store']);
    // Route::post('consult-fdx/{id}', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesFinalDxController::class, 'destroy']);

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
    });

});

