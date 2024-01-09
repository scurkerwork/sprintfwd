<?php

namespace App\Http\Controllers;

use App\Services\MemberService;
use App\Services\ProjectService;
use App\Services\TeamService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use JsonException;

class MemberController extends Controller
{
    protected MemberService $memberService;
    protected TeamService $teamService;
    protected ProjectService $projectService;

    public function __construct(MemberService $memberService, TeamService $teamService, ProjectService $projectService)
    {
        $this->memberService = $memberService;
        $this->teamService = $teamService;
        $this->projectService = $projectService;
    }

    public function index()
    {
        try {
            $response = $this->memberService->getMembers();
            $membersObject = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);
            $members = $membersObject->members;

            return view('members.index', compact('members'));
        } catch (JsonException $e) {
            return view('members.index')->withErrors(['An error occurred while fetching members.']);
        }
    }

    public function create()
    {
        try {
            $teamsResponse = $this->teamService->getTeams();
            $teamsObject = json_decode($teamsResponse->content(), false, 512, JSON_THROW_ON_ERROR);
            $teams = $teamsObject->teams;

            return view('members.create', compact('teams'));
        } catch (JsonException $e) {
            return view('members.create')->withErrors(['An error occurred while fetching teams.']);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $response = $this->memberService->newMember($request);
            $member = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);

            return redirect()->route('members.index')->with('success', $member->message);
        } catch (JsonException $e) {
            return redirect()->route('members.index')->withErrors(['An error occurred while creating a new member.']);
        }
    }

    public function show($id)
    {
        try {
            $member = $this->memberService->showMember($id);

            return view('members.show', compact('member'));
        } catch (JsonException $e) {
            return view('members.show')->withErrors(['An error occurred while fetching the member.']);
        }
    }

    public function edit($id)
    {
        try {
            $member = $this->memberService->showMember($id);

            $teamsResponse = $this->teamService->getTeams();
            $teamsObject = json_decode($teamsResponse->content(), false, 512, JSON_THROW_ON_ERROR);
            $teams = $teamsObject->teams;

            return view('members.edit', compact('member', 'teams'));
        } catch (JsonException $e) {
            return view('members.edit')->withErrors(['An error occurred while fetching the member.']);
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $response = $this->memberService->updateMember($request, $id);
            $member = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);

            return redirect()->route('members.index')->with('success', $member->message);
        } catch (JsonException $e) {
            return redirect()->route('members.index')->withErrors(['An error occurred while updating the member.']);
        }
    }

    public function destroy($id): ?RedirectResponse
    {
        try {
            $this->memberService->deleteMember($id);

            return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('members.index')->withErrors(['An error occurred while deleting the member.']);
        }
    }
}
