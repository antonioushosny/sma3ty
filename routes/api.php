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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('Login', 'ApiController@Login') ;
Route::post('Logout', 'ApiController@Logout') ;
Route::post('Register', 'ApiController@Register') ;
Route::post('EditProfile', 'ApiController@EditProfile') ;
Route::post('ForgetPassword', 'ApiController@ForgetPassword') ;
Route::post('ResetPassword', 'ApiController@ResetPassword') ;
Route::post('homePage', 'ApiController@homePage') ;
Route::post('Doctors', 'ApiController@Doctors') ;
Route::post('Appointments', 'ApiController@Appointments') ;
Route::post('MakeReservations', 'ApiController@MakeReservations') ;
Route::post('myReservations', 'ApiController@myReservations') ;
Route::post('SendMessage', 'ApiController@SendMessage') ;
Route::post('Chats', 'ApiController@Chats') ;
Route::post('Messages', 'ApiController@Messages') ;
Route::post('AboutUs', 'ApiController@AboutUs') ;
 
 
Route::post('count_notification','ApiController@count_notification') ;
Route::post('get_notification','ApiController@get_notification') ;




