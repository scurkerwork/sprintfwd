<?php

namespace App\Http\Controllers;

use App\Services\TeamService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use JsonException;

class TeamController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index()
    {
        try {
            $response = $this->teamService->getTeams();
            $teamsObject = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);
            $teams = $teamsObject->teams;

            return view('teams.index', compact('teams'));
        } catch (JsonException $e) {
            return view('teams.index')->withErrors(['An error occurred while fetching teams.']);
        }
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $response = $this->teamService->newTeam($request);
            $team = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);

            return redirect()->route('teams.index')->with('success', $team->message);
        } catch (JsonException $e) {
            return redirect()->route('teams.index')->withErrors(['An error occurred while creating a new team.']);
        }
    }

    public function show($id)
    {
        try {
            $response = $this->teamService->showTeam($id);
            $teamObject = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);
            $team = $teamObject->team;

            $membersResponse = $this->teamService->getTeamMembers($id);
            $membersObject = json_decode($membersResponse->content(), false, 512, JSON_THROW_ON_ERROR);
            $teamMembers = $membersObject->members;

            return view('teams.show', compact('team', 'teamMembers'));
        } catch (JsonException $e) {
            return view('teams.show')->withErrors(['An error occurred while fetching the team.']);
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->teamService->showTeam($id);
            $teamObject = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);
            $team = $teamObject->team;

            return view('teams.edit', compact('team'));
        } catch (JsonException $e) {
            return view('teams.edit')->withErrors(['An error occurred while fetching the team.']);
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $response = $this->teamService->updateTeam($request, $id);
            $team = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);

            return redirect()->route('teams.index')->with('success', $team->message);
        } catch (JsonException $e) {
            return redirect()->route('teams.index')->withErrors(['An error occurred while updating the team.']);
        }
    }

    public function destroy($id): ?RedirectResponse
    {
        try {
            $this->teamService->deleteTeam($id);

            return redirect()->route('teams.index')->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('teams.index')->withErrors(['An error occurred while deleting the team.']);
        }
    }
}
