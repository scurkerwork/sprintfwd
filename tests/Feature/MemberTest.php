<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_a_member(): void
    {
        $team = Team::factory()->create();

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'team_id' => $team->id,
        ];

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['member', 'message'])
            ->assertJson(['message' => 'Member created successfully.']);
    }

    public function test_update_a_member(): void
    {
        $team = Team::factory()->create();
        $member = Member::factory()->create();

        $data = [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'city' => 'Updated City',
            'state' => 'Updated State',
            'country' => 'Updated Country',
            'team_id' => $team->id,
        ];

        $response = $this->putJson("/api/members/{$member->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['member', 'message'])
            ->assertJson(['message' => 'Member updated successfully.']);
    }

    public function test_delete_a_member(): void
    {
        $member = Member::factory()->create();

        $response = $this->deleteJson("/api/members/{$member->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Member deleted successfully.']);

        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    public function test_get_all_members(): void
    {
        $members = Member::factory(3)->create();

        $response = $this->getJson('/api/members');

        $response->assertStatus(200)
            ->assertJsonStructure(['members'])
            ->assertJsonCount(3, 'members');
    }

    public function test_get_a_single_member(): void
    {
        $member = Member::factory()->create();

        $response = $this->getJson("/api/members/{$member->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'city',
                'state',
                'country',
                'team_id' => ['id', 'name']
            ])
            ->assertJsonFragment([
                'id' => $member->id,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'city' => $member->city,
                'state' => $member->state,
                'country' => $member->country,
                'team_id' => [
                    'id' => $member->team->id,
                    'name' => $member->team->name,
                ]
            ]);
    }

    public function test_update_the_team_of_a_member(): void
    {
        $team = Team::factory()->create();
        $member = Member::factory()->create();

        $response = $this->putJson("/api/members/{$member->id}/update-team", [
            'team_id' => $team->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['member', 'message'])
            ->assertJson(['message' => 'Member team updated successfully.']);
    }
}
