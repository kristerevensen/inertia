<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {

        $projects = Team::query()
                    ->where('user_id', )
                    ->paginate(5); // Or any other query
        return Inertia::render('Dashboard', ['projects' => $projects]);
    }

    public function search(Request $request) {

    }
}
