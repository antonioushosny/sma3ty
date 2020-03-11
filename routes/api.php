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
Route::post('RequestVacation', 'ApiController@RequestVacation') ;
Route::post('ChangeDepartment', 'ApiController@ChangeDepartment') ;
Route::post('Departments', 'ApiController@Departments') ;
Route::post('ChangeMac', 'ApiController@ChangeMac') ;
Route::post('Vacations', 'ApiController@Vacations') ;
Route::post('MyTasks', 'ApiController@MyTasks') ;
Route::post('ChangeStatus', 'ApiController@ChangeStatus') ;
Route::post('TaskByDate', 'ApiController@TaskByDate') ;
Route::post('Attendance', 'ApiController@Attendance') ;
Route::post('AttendanceByMonth', 'ApiController@AttendanceByMonth') ;
Route::post('AttendanceByDate', 'ApiController@AttendanceByDate') ;
Route::post('CheckIn', 'ApiController@CheckIn') ;
Route::post('CheckOut', 'ApiController@CheckOut') ;
Route::post('Salary', 'ApiController@Salary') ;
Route::post('SalaryForMonth', 'ApiController@SalaryForMonth') ;
Route::post('send', 'ApiController@send') ;

 
Route::post('count_notification','ApiController@count_notification') ;
Route::post('get_notification','ApiController@get_notification') ;




