<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;

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

Route::get('/version', function () {
    return response()->success("Version Get Successfully", ["version" => "1.0"]);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('/invitation/process/{token}', [InviteController::class, 'process'])->name('invitation.process');

Route::group(['middleware' => ['auth:api', 'admin', 'authorize']], function () {
    Route::post('/invitation', [InviteController::class, 'store']);
});

Route::group(['middleware' => ['auth:api', 'authorize']], function () {
    Route::post('/otp/{code}', [InviteController::class, 'otp'])->name('otp');
});

Route::group(['middleware' => ['auth:api', 'authorize', 'otp.verification']], function () {
	Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
	Route::get('logout', [AuthController::class, 'logout']);
});

