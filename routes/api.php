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

Route::post('sendLinkForgotPassword', 'AuthenticateController@sendLinkForgotPassword');
Route::post('checkTokenResetValid', 'AuthenticateController@checkTokenResetValid');
Route::post('resetPasswordUser', 'AuthenticateController@resetPasswordUser');

/** ALL ROUTE DEDICATE TO ACL AND USER AUTHENTICATE AND DETAIL USER */
Route::post('authenticate', 'AuthenticateController@authenticate');
Route::post('refreshToken', 'AuthenticateController@refreshToken');





Route::group(['middleware' => 'auth:api'], function () {
    //
    Route::post('logout', 'AuthenticateController@logout');
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
