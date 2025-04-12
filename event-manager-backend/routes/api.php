<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationnController;

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

//Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

//Routes protegees
Route::middleware('auth:sanctum')->group(function() {
    //Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    //Event routes
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);

    //Registration routes
    Route::post('/events/{event}/register', [RegistrationnController::class, 'register']);
    Route::delete('/events/{event}/register', [RegistrationnController::class, 'cancel']);
    Route::get('/user/registrations', [RegistrationnController::class, 'getUserRegistrations']);
    Route::get('/events/{event}/participants', [RegistrationnController::class,'getEventParticipants']);
});
