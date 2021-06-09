<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InviteController;

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

Route::group(['middleware' => ['admin']], function () {
	Route::post('/invitation', [InviteController::class, 'store']);
});
Route::post('/invitation/process/{token}', [InviteController::class, 'process'])->name('invitation.process');
Route::post('/otp/{code}', [InviteController::class, 'otp'])->name('otp');
