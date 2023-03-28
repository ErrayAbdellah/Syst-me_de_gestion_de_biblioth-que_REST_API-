<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use App\Models\Role;
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
    
    Route::get('book/{request}',[UserController::class,'show'] );
    Route::get('book/',[UserController::class,'index'] );
});


Route::group([
    'midlleware' => 'api',
    'prefix' =>'password'
],function(){
    Route::post('reset-password',[AuthController::class , 'resetPassword']);
    Route::post('reset',[AuthController::class , 'reset']);
});

Route::group([

    'middleware' => ['api', 'rec'],
    'prefix' => 'rec',

], function () {
Route::apiResource('book',BookController::class);
});

Route::group([
    'middleware' => ['api', 'isAdmin'],
    'prefix' => 'admin',
],function(){
    Route::apiResource('genre',GenreController::class);
    Route::patch('update-book/{id}',[AdminController::class , 'update']);
    Route::delete('destroy-book/{id}',[AdminController::class , 'destroy']);
    Route::post('role-change/{id}',[AdminController::class , 'roleChange']);
});
