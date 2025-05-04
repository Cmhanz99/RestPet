<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotController;
use App\Http\Controllers\UserController;

Route::get('/', [LotController::class, 'home']);
Route::get('/book/{id}', [UserController::class, 'index']);
Route::post('/pets/{id}', [UserController::class, 'pets']);
Route::get('/user', [UserController::class, 'userHome'])->name('user.home');
Route::get('/bookingHistory', [UserController::class, 'bookingHistory']);

Route::get('/login', [LotController::class, 'index']);
Route::post('/login', [LotController::class, 'login']);
Route::get('/loginUser', [UserController::class, 'loginUser']);
Route::post('/loggedIn', [UserController::class, 'loggedIn']);

Route::get('/register', [LotController::class, 'registration']);
Route::post('/register', [LotController::class, 'register']);
Route::get('/registrationUser', [UserController::class, 'registrationUser']);
Route::post('/registerUser', [UserController::class, 'registerUser']);
Route::get('/favorites', [UserController::class, 'favorites']);

Route::get('/dashboard', [LotController::class, 'dashboard']);
Route::get('/memorial', [LotController::class, 'memorial']);
Route::get('/reservation', [UserController::class, 'reservation']);
Route::get('/setting', [UserController::class, 'settings']);
Route::get('/contact', [UserController::class, 'contact']);
Route::get('/analytics', [UserController::class, 'analytics']);
Route::get('/userProfile', [UserController::class, 'userProfile']);
Route::get('/message', [UserController::class, 'message']);
Route::get('/ownermessage/{id}', [UserController::class, 'ownermessage']);


Route::get('/addProperty', [LotController::class, 'addProperty']);
Route::post('/addProperty', [LotController::class, 'add']);
Route::get('/delete/{id}', [LotController::class, 'delete']);
Route::get('/editLot/{id}', [LotController::class, 'editLot']);
Route::post('/update/{id}', [LotController::class, 'update']);
Route::get('/approve/{id}', [UserController::class, 'approve']);
Route::get('/reject/{id}', [UserController::class, 'reject']);
Route::post('/form', [UserController::class, 'form']);
Route::post('/editPet/{id}', [UserController::class, 'updatePet']);
Route::get('deletePet/{id}', [UserController::class, 'deletePet']);
Route::post('/reply', [UserController::class, 'reply']);





