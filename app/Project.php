<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['projectId', 'name', 'tasksCompleted', 'tasksTodo', 'isCompleted', 'isProcessed'];

      /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function getProjectToProcess()
    {
      return static::where('isProcessed', 0)->first();
    }

    public function resetProcessedProjects()
    {
      return static::query()->update(['isProcessed' => 0]);
    }

    public function getProjectStats($projectId)
    {
      return static::where('isProcessed', 1)
        ->where('projectId', $projectId)
        ->get();
    }

    public function getUniqueProjects()
    {
      return static::select('id', 'projectId', 'name', 'tasksCompleted', 'tasksTodo')
        ->distinct()
        ->get();
    }
}
