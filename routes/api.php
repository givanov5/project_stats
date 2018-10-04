<?php

use Illuminate\Http\Request;
Use App\Project;
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

Route::get('projects', function() {
  // If the Content-Type and Accept headers are set to 'application/json',
  // this will return a JSON structure. This will be cleaned up later.
  return Project::all();
});

Route::get('projects/{id}', function($id) {
  return Project::find($id);
});

Route::post('projects', function(Request $request) {
  return Project::create($request->all);
});

Route::put('projects/{id}', function(Request $request, $id) {
  $project = Project::findOrFail($id);
  $project->update($request->all());

  return $project;
});

Route::delete('projects/{id}', function($id) {
  Project::find($id)->delete();

  return 204;
});

Route::get('projects', 'ProjectController@showAllProjects');
Route::get('projects/{id}', 'ProjectController@show');
Route::post('projects', 'ProjectController@store');
Route::put('projects/{id}', 'ProjectController@update');
Route::delete('projects/{id}', 'ProjectController@delete');
