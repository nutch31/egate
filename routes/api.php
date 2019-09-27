<?php

use Illuminate\Http\Request;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('/test', function (){
    return 'Welcome EGATE API';
});

Route::group(['middleware' => ['api', 'checkToken']], function () {

    Route::post('/landingPageService', 'LeadsController@landingPageService');
    Route::post('/phoneService', 'LeadsController@phoneService');
    Route::get('/getLeads', 'LeadsController@getLeads');
});

Route::get('/testSendEmail', 'TestController@testSendEmail');