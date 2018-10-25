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
    //var_dump('isdide action');die;
    $projectStats = $this->projectModel->getProjectStats($projectId);
    //var_dump($projectStats);die;

    return response()->view(
      'stats.show-project-stats',
      ['projectStats' => $projectStats],
      200
    );
  }

}
