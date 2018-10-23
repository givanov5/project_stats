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

class StatsController extends Controller
{
  /** @var \App\Project  $projectModel*/
  protected $projectModel;

  public function __construct()
  {
    $this->projectModel = new Project;
  }

  public function getProjectStats($id)
  {
    $projectStats = Project::getProjectStats($id);
  }

}
