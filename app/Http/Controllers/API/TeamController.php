<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(): JsonResponse
    {
        $teams = Team::all();
        return response()->json(['teams' => $teams]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::create($validatedData);

        return response()->json(['team' => $team, 'message' => 'Team created successfully.']);
    }

    public function show(Team $team): JsonResponse
    {
        return response()->json(['team' => $team]);
    }

    public function getMembers(Team $team): JsonResponse
    {
        $members = $team->members()->get();

        return response()->json(['members' => $members]);
    }

    public function update(Request $request, Team $team): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->update($validatedData);

        return response()->json(['team' => $team, 'message' => 'Team updated successfully.']);
    }

    public function destroy(Team $team): JsonResponse
    {
        $team->delete();

        return response()->json(['message' => 'Team deleted successfully.']);
    }
}
