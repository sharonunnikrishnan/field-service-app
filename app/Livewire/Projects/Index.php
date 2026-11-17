<?php

namespace App\Livewire\Projects;

use App\Services\ProjectService;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'status', history: true)]
    public string $status = 'all';

    #[Url(as: 'sort', history: true)]
    public string $sortField = 'id';

    #[Url(as: 'dir', history: true)]
    public string $sortDirection = 'desc';

    #[Url(as: 'per_page', history: true)]
    public int $perPage = 10;

    public $projectId = null;

    /**
     * Reset pagination when search query updates.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when status filter updates.
     */
    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when per page updates.
     */
    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    /**
     * Quick toggle / set status filter.
     */
    public function setStatus(string $status): void
    {
        $this->status = $this->status === $status && $status !== 'all' ? 'all' : $status;
        $this->resetPage();
    }

    /**
     * Sort by specified column.
     */
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    /**
     * Clear search filter.
     */
    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    /**
     * Reset all filters to default values.
     */
    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = 'all';
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
        $this->perPage = 10;
        $this->resetPage();
    }

    /**
     * Get paginated projects matching active filters.
     */
    public function getAllProjects(ProjectService $projectService)
    {
        return $projectService->getAllProjects(
            $this->search,
            $this->status,
            $this->sortField,
            $this->sortDirection
        )->paginate($this->perPage);
    }

    /*
     * Function : refreshProjectListing
     */
    #[On('refresh-project-listing')]
    public function refreshProjectListing(): void
    {
        // Re-renders automatically on event
    }

    /*
     * Function : deleteProjectConfirmation
     */
    #[On('delete-project')]
    public function deleteProjectConfirmation($id): void
    {
        $this->projectId = $id;
    }

    /*
     * Function : deleteProject
     */
    public function deleteProject(ProjectService $projectService): void
    {
        if ($this->projectId) {
            $projectService->deleteProject($this->projectId);
            $this->projectId = null;
        }

        $this->dispatch('flash', [
            'message' => 'Project deleted successfully!',
            'type' => 'success'
        ]);

        Flux::modal('delete-project')->close();
    }

    public function render(ProjectService $projectService)
    {
        $projects = $this->getAllProjects($projectService);
        $statusCounts = $projectService->getStatusCounts();

        return view('livewire.projects.index', [
            'projects' => $projects,
            'statusCounts' => $statusCounts,
            'search' => $this->search,
            'status' => $this->status,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
            'perPage' => $this->perPage,
        ]);
    }
}
