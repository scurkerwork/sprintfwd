<?php

namespace App\Services;

use App\Http\Controllers\API\TeamController;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamService
{
    protected TeamController $teamController;

    public function __construct(TeamController $teamController)
    {
        $this->teamController = $teamController;
    }

    public function getTeams(): JsonResponse
    {
        return $this->teamController->index();
    }

    public function getTeamMembers($id): JsonResponse
    {
        $team = Team::findOrFail($id);

        return $this->teamController->getMembers($team);
    }

    public function newTeam(Request $request): JsonResponse
    {
        return $this->teamController->store($request);
    }

    public function showTeam($id): JsonResponse
    {
        $team = Team::findOrFail($id);

        return $this->teamController->show($team);
    }

    public function updateTeam(Request $request, $id): JsonResponse
    {
        $team = Team::findOrFail($id);

        return $this->teamController->update($request, $team);
    }

    public function deleteTeam($id): JsonResponse
    {
        $team = Team::findOrFail($id);

        return $this->teamController->destroy($team);
    }
}
