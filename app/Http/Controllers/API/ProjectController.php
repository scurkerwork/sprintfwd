<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::all();
        return response()->json(['projects' => $projects]);
    }

    public function getMembers(Project $project): JsonResponse
    {
        $members = $project->members()->get();

        return response()->json(['members' => $members]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project = Project::create($validatedData);

        return response()->json(['project' => $project, 'message' => 'Project created successfully.']);
    }

    public function addMember(Request $request, Project $project): JsonResponse
    {
        $validatedData = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $project->members()->attach($validatedData['member_id']);

        return response()->json(['project' => $project, 'message' => 'Member added to project successfully.']);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json(['project' => $project]);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project->update($validatedData);

        return response()->json(['project' => $project, 'message' => 'Project updated successfully.']);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
