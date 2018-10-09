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

Route::get('projects/show', 'ProjectController@showAllProjects');
Route::get('projects/import', 'ProjectController@importAllProjects');
Route::get('projects/process', 'ProjectController@processProject');
Route::get('projects/reset', 'ProjectController@resetProcessedProjects');
Route::get('projects/get/{id}', 'ProjectController@getProject');
Route::post('projects/create', 'ProjectController@create');
Route::put('projects/update/{id}', 'ProjectController@update');
Route::delete('projects/delete/{id}', 'ProjectController@delete');
