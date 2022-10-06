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
    Route::post('patient', [\App\Http\Controllers\API\V1\Patient\PatientController::class, 'store'])->name('patient.store');

    //Childcare APIs
    Route::post('childcare-vaccine', [\App\Http\Controllers\API\V1\Childcare\ConsultCcdevVaccineController::class, 'store']);
    Route::get('childcare-vaccine/{id}', [\App\Http\Controllers\API\V1\Childcare\ConsultCcdevVaccineController::class, 'show']);

    //Consultation APIs
    Route::post('consult', [\App\Http\Controllers\API\V1\Consultation\ConsultController::class, 'store']);
    Route::post('complaint', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesComplaintController::class, 'store']);
    Route::post('consult-idx', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesInitialDxController::class, 'store']);
    Route::post('consult-fdx', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesFinalDxController::class, 'store']);
    Route::post('consult-fdx/{id}', [\App\Http\Controllers\API\V1\Consultation\ConsultNotesFinalDxController::class, 'destroy']);

    Route::post('bfed', [\App\Http\Controllers\API\V1\Childcare\ConsultCcdevBreastfedController::class, 'store']);


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

        Route::get('provinces', [\App\Http\Controllers\API\V1\PSGC\ProvinceController::class, 'index'])->name('province.index');
        Route::get('provinces/{province}', [\App\Http\Controllers\API\V1\PSGC\ProvinceController::class, 'show'])->name('province.show');

        Route::get('districts', [\App\Http\Controllers\API\V1\PSGC\DistrictController::class, 'index'])->name('district.index');
        Route::get('districts/{district}', [\App\Http\Controllers\API\V1\PSGC\DistrictController::class, 'show'])->name('district.show');

        Route::get('cities', [\App\Http\Controllers\API\V1\PSGC\CityController::class, 'index'])->name('city.index');
        Route::get('cities/{city}', [\App\Http\Controllers\API\V1\PSGC\CityController::class, 'show'])->name('city.show');

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

        //Consultation Libraries
        Route::get('complaint', [\App\Http\Controllers\API\V1\Libraries\LibComplaintController::class, 'index']);
        Route::get('complaint/{id}', [\App\Http\Controllers\API\V1\Libraries\LibComplaintController::class, 'show']);
        Route::get('pe', [\App\Http\Controllers\API\V1\Libraries\LibPeController::class, 'index']);
        Route::get('pe/{id}', [\App\Http\Controllers\API\V1\Libraries\LibPeController::class, 'show']);
        Route::get('diagnosis', [\App\Http\Controllers\API\V1\Libraries\LibDiagnosisController::class, 'index']);
        Route::get('diagnosis/{id}', [\App\Http\Controllers\API\V1\Libraries\LibDiagnosisController::class, 'show']);
        Route::get('icd10', [\App\Http\Controllers\API\V1\Libraries\LibIcd10Controller::class, 'index']);
        Route::get('icd10/{id}', [\App\Http\Controllers\API\V1\Libraries\LibIcd10Controller::class, 'show']);

    });

});

