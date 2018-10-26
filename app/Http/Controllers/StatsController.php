<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 23.10.18
 * Time: 17:31
 */

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StatsController extends Controller
{
  /** @var \App\Project  $projectModel*/
  protected $projectModel;

  public function __construct()
  {
    $this->projectModel = new Project;
  }

  public function listAllProjects()
  {
    $projects = $this->projectModel->getUniqueProjects();

    return response()->view(
      'stats.list-all-projects',
      ['projects' => $projects],
      200
    );
  }

  public function showProjectStats($projectId)
  {
    $projectStats = $this->projectModel->getProjectStats($projectId);
    //echo '<pre>';
    //var_dump($projectStats->toArray());die;
    $tasksToDo = [];
    $tasksDone = [];
    $dates = [];

    /** @var \App\Project $projectStat */
    foreach ($projectStats as $projectStat) {
      $tasksToDo[] = $projectStat->tasksTodo;
      $tasksDone[] = $projectStat->tasksCompleted;
      $dates[] = $projectStat->updated_at->format('d/m/Y');
    }
    //var_dump(json_encode($dates), $dates);die;
    //var_dump($tasksToDo,$tasksDone,$dates );die;

    return response()->view(
      'stats.show-project-stats',
      [
        'tasksToDo' => $tasksToDo,
        'tasksDone' => $tasksDone,
        'dates' => $dates,
      ],
      200
    );
  }

}
