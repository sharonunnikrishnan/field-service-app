<?php

namespace App\Livewire\Projects;

use App\Services\ProjectService;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $projectId = null;

    public function getAllProjects(ProjectService $projectService)
    {
        return $projectService->getAllProjects()->orderBy('id', 'DESC')->paginate(10);
    }

    /*
    * Function : refreshProjectListing
    */
    #[On('refresh-project-listing')]
    public function refreshProjectListing(ProjectService $projectService)
    {
        $this->getAllProjects($projectService);
    }

    /*
    * Function : deleteProjectConfirmation
    */
    #[On('delete-project')]
    public function deleteProjectConfirmation($id)
    {
        $this->projectId = $id;
    }

    /*
    * Function : deleteProject
    */
    public function deleteProject(ProjectService $projectService)
    {
        if($this->projectId)
        {
            $projectService->deleteProject($this->projectId);
        }

         $this->dispatch('flash', [
            'message' => 'Project deleted successfully!',
            'type' => 'success'
        ]);

        $this->dispatch('$refresh');

        Flux::modal('delete-project')->close();
    }

    public function render(ProjectService $projectService)
    {
        $projects = $this->getAllProjects($projectService);
        return view('livewire.projects.index', compact('projects'));
    }
}
