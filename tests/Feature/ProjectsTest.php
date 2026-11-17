<?php

namespace Tests\Feature;

use App\Livewire\Projects\Index;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_page(): void
    {
        $response = $this->get(route('projects'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_see_projects_page(): void
    {
        $user = User::factory()->create();

        Project::create([
            'name' => 'Project Alpha',
            'slug' => 'project-alpha',
            'description' => 'Alpha description for testing',
            'status' => 'pending',
            'deadline' => '2026-12-31',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('projects'));
        $response->assertOk();
        $response->assertSee('Project Management');
        $response->assertSee('Project Alpha');
    }

    public function test_livewire_can_dynamically_filter_by_search_keystroke(): void
    {
        $user = User::factory()->create();

        Project::create([
            'name' => 'Alpha CRM',
            'slug' => 'alpha-crm',
            'description' => 'Building CRM platform',
            'status' => 'in-progress',
            'deadline' => '2026-11-15',
        ]);

        Project::create([
            'name' => 'Beta Mobile App',
            'slug' => 'beta-mobile-app',
            'description' => 'Field mobile app',
            'status' => 'completed',
            'deadline' => '2026-12-01',
        ]);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertSee('Alpha CRM')
            ->assertSee('Beta Mobile App')
            ->set('search', 'Alpha')
            ->assertSee('Alpha CRM')
            ->assertDontSee('Beta Mobile App')
            ->set('search', 'Field mobile')
            ->assertSee('Beta Mobile App')
            ->assertDontSee('Alpha CRM')
            ->call('clearSearch')
            ->assertSee('Alpha CRM')
            ->assertSee('Beta Mobile App');
    }

    public function test_livewire_can_filter_by_status(): void
    {
        $user = User::factory()->create();

        Project::create([
            'name' => 'Pending Project',
            'slug' => 'pending-project',
            'description' => 'Pending work',
            'status' => 'pending',
            'deadline' => '2026-11-20',
        ]);

        Project::create([
            'name' => 'Completed Project',
            'slug' => 'completed-project',
            'description' => 'Done work',
            'status' => 'completed',
            'deadline' => '2026-10-10',
        ]);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('setStatus', 'pending')
            ->assertSee('Pending Project')
            ->assertDontSee('Completed Project')
            ->call('setStatus', 'completed')
            ->assertSee('Completed Project')
            ->assertDontSee('Pending Project')
            ->call('setStatus', 'all')
            ->assertSee('Pending Project')
            ->assertSee('Completed Project');
    }

    public function test_livewire_can_sort_columns_and_reset_filters(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->set('search', 'something')
            ->set('status', 'in-progress')
            ->call('sortBy', 'name')
            ->assertSet('sortField', 'name')
            ->assertSet('sortDirection', 'asc')
            ->call('sortBy', 'name')
            ->assertSet('sortDirection', 'desc')
            ->call('resetFilters')
            ->assertSet('search', '')
            ->assertSet('status', 'all')
            ->assertSet('sortField', 'id')
            ->assertSet('sortDirection', 'desc');
    }
}
