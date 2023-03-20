<?php

use App\Http\Controllers\AuthController;
use App\Models\Book;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login',    [AuthController::class, 'login'     ]);
    Route::post('register', [AuthController::class, 'register'  ]);
    Route::post('logout',   [AuthController::class, 'logout'    ]);
    Route::post('refresh',  [AuthController::class, 'refresh'   ]);
    Route::get('me',        [AuthController::class, 'me'        ]);
    Route::post('logout',   [AuthController::class, 'logout'    ]);
    Route::post('updateProfile',   [AuthController::class, 'updateProfile'    ]);
    
    
});

Route::group([
    'midlleware' => 'api',
    'prefix' =>'password'
],function(){
    Route::post('reset-password',[AuthController::class , 'resetPassword']);
    Route::post('reset',[AuthController::class , 'reset']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'v1'

], function () {
Route::apiResource('book',function-);

});