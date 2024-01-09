<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_a_team(): void
    {
        $data = [
            'name' => $this->faker->word,
        ];

        $response = $this->postJson('/api/teams', $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['team', 'message'])
            ->assertJson(['message' => 'Team created successfully.']);
    }

    public function test_update_a_team(): void
    {
        $team = Team::factory()->create();

        $data = [
            'name' => 'Updated Team Name',
        ];

        $response = $this->putJson("/api/teams/{$team->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['team', 'message'])
            ->assertJson(['message' => 'Team updated successfully.']);
    }

    public function test_delete_a_team(): void
    {
        $team = Team::factory()->create();

        $response = $this->deleteJson("/api/teams/{$team->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Team deleted successfully.']);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }

    public function test_get_all_teams(): void
    {
        $teams = Team::factory(3)->create();

        $response = $this->getJson('/api/teams');

        $response->assertStatus(200)
            ->assertJsonStructure(['teams'])
            ->assertJsonCount(3, 'teams');
    }

    public function test_get_a_single_team(): void
    {
        $team = Team::factory()->create();

        $response = $this->getJson("/api/teams/{$team->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['team'])
            ->assertJson(['team' => $team->toArray()]);
    }

    public function test_get_members_of_a_specific_team(): void
    {
        $team = Team::factory()->create();
        $members = Member::factory(3)->create(['team_id' => $team->id]);

        $response = $this->getJson("/api/teams/{$team->id}/members");

        $response->assertStatus(200)
            ->assertJsonStructure(['members'])
            ->assertJsonCount(3, 'members');
    }
}
