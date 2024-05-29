<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 1. Service route
Route::controller(ServiceController::class)->group(function () {
    Route::get('services', 'index')->name('services');
    Route::post('service/store', 'store')->name('service.store');
    Route::get('service-details/{slug}/{id}', 'show')->name('service.details');
    Route::get('service/delete/{id}', 'delete')->name('service.delete');
    Route::post('service/update/{id}', 'update')->name('service.update');
});

// 2. Appointment booking route
Route::controller(AppointmentController::class)->group(function () {
    Route::get('appointments', 'index')->name('appointments');
    Route::post('appointment/store', 'store')->name('appointment.store');
    Route::get('appointment-details/{id}', 'show')->name('appointment.details');
    Route::get('appointment/delete/{id}', 'delete')->name('appointment.delete');
    Route::post('appointment/update/{id}', 'update')->name('appointment.update');
});

// 3. Contact route
Route::controller(ContactController::class)->group(function () {
    Route::get('contacts', 'index')->name('contacts');
    Route::post('contact/store', 'store')->name('contact.store');
    Route::get('contact/delete/{id}', 'delete')->name('contact.delete');
});
