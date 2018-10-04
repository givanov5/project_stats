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

class ProjectController extends Controller
{
  public function showAllProjects()
  {
    return response()->json(Project::all());
  }

  public function getProject($id)
  {
    return  response()->json(Project::find($id));
  }

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

  public function update($id, Request $request)
  {
    $project = Project::findOrFail($id);
    $project->update($request->all());

    return response()->json($project, 200);
  }

  public function delete($id)
  {
    Project::findOrFail($id)->delete();

    return response('Project deleted successfully', 200);
  }
}
