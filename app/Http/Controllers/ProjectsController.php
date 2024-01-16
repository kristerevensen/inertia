<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {

        $userId = Auth::user()->id;

            $teams = Team::query()
                ->where('user_id', $userId)
                ->whereNotIn('id', function ($query) use ($userId) {
                    $query->select('team_id')
                        ->from('projects')
                        ->where('user_id', $userId);
                })
                ->get();

            $projects = Project::query()
                ->leftJoin('teams', 'projects.team_id', '=', 'teams.id')
                ->select('projects.*', 'teams.name as team_name')
                ->when($request->input('search'), function ($query) use ($request) {
                    $query->where('projects.name', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('projects.domain', 'like', '%' . $request->input('search') . '%');
                })
                ->paginate(5);
        return Inertia::render('Dashboard', [
            'projects' => $projects,
            'teamsProject' => $teams
        ]);
    }

    public function edit(Request $request, $project_code)
    {
        $project = Project::where('project_code', $project_code)
            ->where('owner_id', Auth::user()->id)
            ->firstOrFail();

        //dd($project);
        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'project_code' => $project_code
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'projectName' => 'required',
            'domain' => 'required',
            'selectedTeamId' => 'required',
        ]);

        $project = Project::create([
            'name' => $request->input('projectName'),
            'domain' => $request->input('domain'),
            'categories' => $request->input('websiteCategories') ? implode(',', $request->input('websiteCategories')) : null,
            'description' => $request->input('projectDescription'),
            'team_id' => $request->input('selectedTeamId'),
            'owner_id' => Auth::user()->id,
            'project_code' => md5(now()),
            'language' => $request->input('language') ?? null,
            //'location' => $request->input('location') ?? null,
            'country' => $request->input('country') ?? null,

        ]);


        return redirect()->route('dashboard')->with('success', 'Project created successfully');
    }
    public function delete(Request $request, Project $project_code)
    {
        $project = Project::query()
                    ->where('project_code', $project_code)
                    ->where('owner_id', Auth::user()->id)
                    ->firstOrFail();

        redirect()->route('dashboard')->with('success', 'Project deleted successfully');
    }

    public function search(Request $request) {

    }
}
