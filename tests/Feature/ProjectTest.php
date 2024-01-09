<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_a_project(): void
    {
        $data = [
            'name' => $this->faker->word,
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['project', 'message'])
            ->assertJson(['message' => 'Project created successfully.']);
    }

    public function test_update_a_project(): void
    {
        $project = Project::factory()->create();

        $data = [
            'name' => 'Updated Project Name',
        ];

        $response = $this->putJson("/api/projects/{$project->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['project', 'message'])
            ->assertJson(['message' => 'Project updated successfully.']);
    }

    public function test_delete_a_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Project deleted successfully.']);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_get_all_projects(): void
    {
        $projects = Project::factory(3)->create();

        $response = $this->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJsonStructure(['projects'])
            ->assertJsonCount(3, 'projects');
    }

    public function test_get_a_single_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->getJson("/api/projects/{$project->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['project'])
            ->assertJson(['project' => $project->toArray()]);
    }

    public function test_add_a_member_to_a_project(): void
    {
        $project = Project::factory()->create();
        $member = Member::factory()->create();

        $response = $this->postJson("/api/projects/{$project->id}/add-member", [
            'member_id' => $member->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['project', 'message'])
            ->assertJson(['message' => 'Member added to project successfully.']);
    }

    public function test_get_members_of_a_specific_project(): void
    {
        $project = Project::factory()->create();
        $members = Member::factory(3)->create();
        $project->members()->attach($members->pluck('id'));

        $response = $this->getJson("/api/projects/{$project->id}/members");

        $response->assertStatus(200)
            ->assertJsonStructure(['members'])
            ->assertJsonCount(3, 'members');
    }
}
