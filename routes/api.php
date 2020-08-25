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

Route::group(['prefix' => '/v1', 'namespace' => 'Api', 'as' => 'api.'], function () {
    // Users
    Route::get('users', 'UserController@index')->name('users.index');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::get('users/show/{id}', 'UserController@show')->name('users.show');
    Route::patch('users/update/{id}', 'UserController@update')->name('users.update');
    Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
    // gender
    Route::get('users/gender', 'UserController@getGenders')->name('gender');
    // department
    Route::get('users/department', 'UserController@getDepartments')->name('department');
    // upload image
    Route::patch('upload/avatar', 'UserController@uploadAvatar')->name('upload-avatar');
});