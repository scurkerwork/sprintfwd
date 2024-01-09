<?php

namespace App\Services;

use App\Http\Controllers\API\ProjectController;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectService
{
    protected ProjectController $projectController;

    public function __construct(ProjectController $projectController)
    {
        $this->projectController = $projectController;
    }

    public function getProjects(): JsonResponse
    {
        return $this->projectController->index();
    }

    public function newProject(Request $request): JsonResponse
    {
        return $this->projectController->store($request);
    }

    public function addMemberToProject(Request $request, $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        return $this->projectController->addMember($request, $project);
    }

    public function showProject($id): JsonResponse
    {
        $project = Project::findOrFail($id);

        return $this->projectController->show($project);
    }

    public function getMembersForProject($id): JsonResponse
    {
        $project = Project::findOrFail($id);

        return $this->projectController->getMembers($project);
    }

    public function updateProject(Request $request, $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        return $this->projectController->update($request, $project);
    }

    public function deleteProject($id): JsonResponse
    {
        $project = Project::findOrFail($id);

        return $this->projectController->destroy($project);
    }
}
