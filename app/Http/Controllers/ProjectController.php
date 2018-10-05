<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 03.10.18
 * Time: 16:23
 */

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Services\JiraApiClient;

class ProjectController extends Controller
{

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function showAllProjects()
  {
    return response()->json(Project::all());
  }

  /**
   * @param $id
   * @param \App\Services\JiraApiClient $jiraApiClient
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function getProject($id, JiraApiClient $jiraApiClient)
  {
    $projectResponse = $jiraApiClient->getProject('BAC');
    //var_dump($projectResponse);die;
    return  response()->json(Project::find($id));
  }

  /**
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function create(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|unique:project',
      'tasksCompleted' => 'required',
      'tasksTodo' => 'required',
      'isCompleted' => 'required',
    ]);

    $project = Project::create($request->all());
    return response()->json($project, 201);
  }

  /**
   * @param $id
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function update($id, Request $request)
  {
    $project = Project::findOrFail($id);
    $project->update($request->all());

    return response()->json($project, 200);
  }

  /**
   * @param $id
   *
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function delete($id)
  {
    Project::findOrFail($id)->delete();

    return response('Project deleted successfully', 200);
  }
}
