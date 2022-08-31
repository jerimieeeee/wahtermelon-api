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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function (){
    Route::post('login', [\App\Http\Controllers\API\Auth\AuthenticationController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\API\V1\UserController::class, 'store']);

    Route::get('regions', [\App\Http\Controllers\API\V1\PSGC\RegionController::class, 'index'])->name('region.index');
    Route::get('regions/{region}', [\App\Http\Controllers\API\V1\PSGC\RegionController::class, 'show'])->name('region.show');

    Route::get('provinces', [\App\Http\Controllers\API\V1\PSGC\ProvinceController::class, 'index'])->name('province.index');
    Route::get('provinces/{province}', [\App\Http\Controllers\API\V1\PSGC\ProvinceController::class, 'show'])->name('province.show');

    Route::get('districts', [\App\Http\Controllers\API\V1\PSGC\DistrictController::class, 'index'])->name('district.index');
    Route::get('districts/{district}', [\App\Http\Controllers\API\V1\PSGC\DistrictController::class, 'show'])->name('district.show');

    Route::get('cities', [\App\Http\Controllers\API\V1\PSGC\CityController::class, 'index'])->name('city.index');
    Route::get('cities/{city}', [\App\Http\Controllers\API\V1\PSGC\CityController::class, 'show'])->name('city.show');

    Route::get('municipalities', [\App\Http\Controllers\API\V1\PSGC\MunicipalityController::class, 'index'])->name('municipality.index');
    Route::get('municipalities/{municipality}', [\App\Http\Controllers\API\V1\PSGC\MunicipalityController::class, 'show'])->name('municipality.show');

    Route::get('sub-municipalities', [\App\Http\Controllers\API\V1\PSGC\SubMunicipalityController::class, 'index'])->name('sub-municipality.index');
    Route::get('sub-municipalities/{subMunicipality}', [\App\Http\Controllers\API\V1\PSGC\SubMunicipalityController::class, 'show'])->name('sub-municipality.show');

    Route::get('barangays', [\App\Http\Controllers\API\V1\PSGC\BarangayController::class, 'index'])->name('barangay.index');
    Route::get('barangays/{barangay}', [\App\Http\Controllers\API\V1\PSGC\BarangayController::class, 'show'])->name('barangay.show');
});

