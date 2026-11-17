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
    public function getProjectQuery(?string $search = null, ?string $status = null, string $sortField = 'id', string $sortDirection = 'desc')
    {
        $query = Project::query();

        if (!empty($search)) {
            $search = trim($search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        $allowedSortFields = ['id', 'name', 'status', 'deadline', 'created_at'];
        if (!in_array($sortField, $allowedSortFields, true)) {
            $sortField = 'id';
        }

        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortField, $sortDirection);
    }

    /**
     * Get counts grouped by status.
     */
    public function getStatusCounts(): array
    {
        $counts = Project::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'all' => Project::count(),
            'in-progress' => $counts['in-progress'] ?? 0,
            'completed' => $counts['completed'] ?? 0,
            'pending' => $counts['pending'] ?? 0,
            'cancelled' => $counts['cancelled'] ?? 0,
        ];
    }
}

