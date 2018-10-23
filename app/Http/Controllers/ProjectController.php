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
  /** @var \App\Project  $projectModel*/
  protected $projectModel;

  public function __construct()
  {
    $this->projectModel = new Project;
  }

  public function importAllProjects(JiraApiClient $jiraApiClient)
  {
    $projectsResponse = $jiraApiClient->getProjects();
    if (!empty($projectsResponse['body'])) {
      foreach ($projectsResponse['body'] as $project) {
        $projectKey = $project['key'];
        $totalCompletedTasks = 0;
        $totalNotCompletedTasks = 0;
        $projectName = $project['name'];

        Project::create([
          'name' => $projectName,
          'projectId' => $projectKey,
          'tasksCompleted' => $totalCompletedTasks,
          'tasksTodo' => $totalNotCompletedTasks,
          'isProcessed' => 0,
          'isCompleted' => 0
        ]);
      }
    }
    return response()->json(['message' => 'All Jira Projects Imported!'], 200);
  }

  public function processProject(JiraApiClient $jiraApiClient)
  {
    /** @var Project $project */
    $project = $this->projectModel->getProjectToProcess();
    if(!empty($project)){
      $projectArr = $project->toArray();
      $projectKey = $projectArr['projectId'];
      $fieldsToUpdate = [];

      $jqlNotCompetedTasks = 'project = "' . $projectKey . '" AND status not in (Closed, Completed, Done, Resolved) ORDER BY project';
      //var_dump($projectArr);die;
      $projectResponse = $jiraApiClient->search($jqlNotCompetedTasks);
      if (!empty($projectResponse['body'])) {
        //var_dump($projectResponse['body']);die;
        $fieldsToUpdate['tasksTodo'] = $projectResponse['body']['total'];
      }

      $jqlCompletedTasks = 'project = "' . $projectKey . '" AND status in (Closed, Completed, Done, Resolved) ORDER BY project';
      $projectResponse = $jiraApiClient->search($jqlCompletedTasks);
      if (!empty($projectResponse['body'])) {
        $fieldsToUpdate['tasksCompleted'] = $projectResponse['body']['total'];
      }
      $fieldsToUpdate['isProcessed'] = 1;
      $project->update($fieldsToUpdate);

      return response()->json(['message' => 'Project ' . $projectArr['projectId'] . ' updated!'], 200);
    }
    return response()->json(['message' => 'No projects to update found!'], 200);

  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function showAllProjects()
  {
    return response()->json(Project::all());
  }

  public function resetProcessedProjects()
  {
    $this->projectModel->getProjectToProcess();

    return response()->json(['message' => 'All projects reset!'], 200);
  }

  /**
   * @param $id
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function getProject($id)
  {
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
