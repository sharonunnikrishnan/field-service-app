<?php

namespace App\Livewire\Projects;

use App\Services\ProjectService;
use Flux\Flux;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormModal extends Component
{
    use WithFileUploads;

    public $name = null;
    public $description = null;
    public $deadline = null;
    public $status = 'pending';
    public $project_logo = null;

    public $projectId = null;
    public $isView = false;
    public $existingImage = null;

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('projects', 'name')->ignore($this->projectId),
            ],
            'description' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,in-progress,completed,cancelled',
            'project_logo' => 'nullable|image|max:5120',
        ];
    }

    /*
    * Function : Save Project
    */
    public function saveProject(ProjectService $projectService)
    {
        #Validating form here
        $validatedProjectRequest =  $this->validate();

        if($this->projectId) {
            $projectService->updateProject($this->projectId, $validatedProjectRequest);
        }
        else{
            $projectService->saveProject($validatedProjectRequest);
        }


        $this->reset();

        $this->dispatch('flash', [
            'message' => 'Project created successfully!',
            'type' => 'success'
        ]);

        $this->dispatch('refresh-project-listing');
        Flux::modal('project-modal')->close();
    }

    #[On('open-project-modal')]
    public function projectDetail($mode, $project = null)
    {
        $this->isView = $mode === 'view';

        if($mode === 'create')
        {
            $this->isView = 'false';
            $this->projectId = null;
            $this->existingImage = null;
            $this->reset();
        }
        else
        {
            $this->projectId = $project['id'];
            $this->name = $project['name'];
            $this->description = $project['description'];
            $this->deadline = $project['deadline'];
            $this->status = $project['status'];
            $this->existingImage = $project['project_logo'];
        }

    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
