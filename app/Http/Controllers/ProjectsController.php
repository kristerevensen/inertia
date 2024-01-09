<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {

        $projects = Project::query()
                    ->when($request->input('search'), function ($query) use ($request) {
                        $query->where('name','like','%'. $request->input('search') .'%')
                        ->orWhere('domain','like','%'. $request->input('search') .'%');
                        })
                        ->paginate(5); // Or any other query
        return Inertia::render('Dashboard', ['projects' => $projects]);
    }

}
