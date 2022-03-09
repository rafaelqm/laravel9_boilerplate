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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::resource('procedures', App\Http\Controllers\API\ProcedureAPIController::class);
//Route::resource('attendance_typifications', App\Http\Controllers\API\AttendanceTypificationAPIController::class);
//Route::resource('cities', App\Http\Controllers\API\CityAPIController::class);
//Route::resource('people', App\Http\Controllers\API\PersonAPIController::class);
//Route::resource('addresses', App\Http\Controllers\API\AddressAPIController::class);
//Route::resource('doctors', App\Http\Controllers\API\DoctorAPIController::class);
//Route::resource('health_units', App\Http\Controllers\API\HealthUnitAPIController::class);
//Route::resource('patients', App\Http\Controllers\API\PatientAPIController::class);
//Route::resource('executants', App\Http\Controllers\API\ExecutantAPIController::class);
//Route::resource('attendance_statuses', App\Http\Controllers\API\AttendanceStatusAPIController::class);
//Route::resource('attendances', App\Http\Controllers\API\AttendanceAPIController::class);
//Route::resource('health_insurance_companies', App\Http\Controllers\API\HealthInsuranceCompaniesAPIController::class);


Route::resource('attendance_requests', App\Http\Controllers\API\AttendanceRequestAPIController::class);
