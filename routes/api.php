<?php

use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('teams', TeamController::class);
Route::get('/teams/{team}/members', [TeamController::class, 'getMembers']);

Route::apiResource('members', MemberController::class);
Route::put('/members/{member}/update-team', [MemberController::class, 'updateTeam']);

Route::apiResource('projects', ProjectController::class);
Route::post('/projects/{project}/add-member', [ProjectController::class, 'addMember']);
Route::get('/projects/{project}/members', [ProjectController::class, 'getMembers']);





