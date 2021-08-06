<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::group(
    ['prefix' => 'v1'],
    function(){
        Route::post('/login',[AuthController::class, 'Login']);
        Route::post('/register',[AuthController::class, 'Register']);
        Route::post('/refresh-token',[UserController::class, 'refreshToken']);
        Route::group(['middleware' => ['auth:api']], function () {

            Route::get('/user',[ UserController::class,'getUserProfile']);
            Route::post('/user/update',[ UserController::class,'updateUserProfile']);
            Route::post('/logout', [LogoutController::class,'logout']);

        });
        // Route::middleware('auth:api')->get('/user', function (Request $request) {
        //     return $request->user();
        // });
    }


);


