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

        $teams = Team::query()
                    ->where('user_id', Auth::user()->id)
                    ->get();

        $projects = Project::query()
                    ->when($request->input('search'), function ($query) use ($request) {
                        $query->where('name','like','%'. $request->input('search') .'%')
                        ->orWhere('domain','like','%'. $request->input('search') .'%');
                        })
                        ->paginate(5); // Or any other query
        return Inertia::render('Dashboard', [
            'projects' => $projects,
            'teamsProject' => $teams
        ]);
    }

    public function search(Request $request) {

    }
}
