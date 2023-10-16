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

Route::post('/login', function (Request $request) {
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json(['success'=>'true','data' => $user,'message'=>'Action Successful'], 200);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::post('/auth/login', 'App\Http\Controllers\ApiController@login');
Route::middleware('auth:sanctum')->post('/auth/logout', 'App\Http\Controllers\ApiController@logout');

Route::get('/visit-purpose-list', 'App\Http\Controllers\ApiController@visit_purpose_list');
Route::get('/department-list', 'App\Http\Controllers\ApiController@department_list');


Route::middleware('auth:sanctum')->post('/auth/store-visitor', [App\Http\Controllers\ApiController::class, 'store_visitor']);

Route::middleware('auth:sanctum')->get('/auth/search-visitor','App\http\Controllers\ApiController@searchVisitors');

Route::middleware('auth:sanctum')->get('/auth/todays-visitor','App\http\Controllers\ApiController@todaysVisitors');

Route::middleware('auth:sanctum')->get('/auth/search-exit-visitor','App\http\Controllers\ApiController@exitsearchVisitors');

Route::middleware('auth:sanctum')->get('/auth/todays-exit-visitor','App\http\Controllers\ApiController@exittodaysVisitors');

Route::middleware('auth:sanctum')->put('/auth/update-exit-datetime/{id}','App\http\Controllers\ApiController@updateexitDatetime');

Route::middleware('auth:sanctum')->get('/auth/check-pass-id', 'App\http\Controllers\ApiController@checkPassId');

Route::middleware('auth:sanctum')->get('/dashboard-counts','App\http\Controllers\ApiController@dashboard_counts');