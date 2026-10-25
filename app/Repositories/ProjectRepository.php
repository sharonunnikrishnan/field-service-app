<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /*
    * Funtion : saveProject
    */
    public function saveProject($projectRequest)
    {
        return Project::create($projectRequest);
    }

    /*
    * Funtion : getProjectQuery
    */
    public function getProjectQuery()
    {
        return Project::query();
    }
}
