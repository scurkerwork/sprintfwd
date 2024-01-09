<?php

namespace App\Services;

use App\Http\Controllers\API\MemberController;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberService
{
    protected MemberController $memberController;

    public function __construct(MemberController $memberController)
    {
        $this->memberController = $memberController;
    }

    public function getMembers(): JsonResponse
    {
        return $this->memberController->index();
    }

    public function newMember(Request $request): JsonResponse
    {
        return $this->memberController->store($request);
    }

    public function showMember($id): MemberResource
    {
        $member = Member::findOrFail($id);

        return $this->memberController->show($member);
    }

    public function updateMember(Request $request, $id): JsonResponse
    {
        $member = Member::findOrFail($id);

        return $this->memberController->update($request, $member);
    }

    public function deleteMember($id): JsonResponse
    {
        $member = Member::findOrFail($id);

        return $this->memberController->destroy($member);
    }
}
