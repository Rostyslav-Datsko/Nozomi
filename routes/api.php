<?php

use App\Http\Controllers\API\UserAPI;
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

Route::get("/users",[UserAPI::class, 'getAllUsers']);
Route::get("/users/{id}",[UserAPI::class, 'getUsersByID']);
Route::post("/users",[UserAPI::class, 'createUser']);
Route::put("/users/{id}", [UserAPI::class, 'updateUserByID']);
Route::delete("/users/{id}", [UserAPI::class, 'deleteUserByID']);
Route::post("/authorization", [UserAPI::class, 'authorization']);
