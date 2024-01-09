<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MemberController extends Controller
{
    public function index(): JsonResponse
    {
        $members = Member::all();
        return response()->json(['members' => $members]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ]);

        $member = Member::create($validatedData);

        return response()->json(['member' => $member, 'message' => 'Member created successfully.']);
    }

    public function show(Member $member): MemberResource
    {
        return new MemberResource($member);
    }

    public function update(Request $request, Member $member): JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ]);

        $member->update($validatedData);

        return response()->json(['member' => $member, 'message' => 'Member updated successfully.']);
    }

    public function destroy(Member $member): JsonResponse
    {
        $member->delete();

        return response()->json(['message' => 'Member deleted successfully.']);
    }

    public function updateTeam(Request $request, Member $member): JsonResponse
    {
        $validatedData = $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        $member->update(['team_id' => $validatedData['team_id']]);

        return response()->json(['member' => $member, 'message' => 'Member team updated successfully.']);
    }
}
