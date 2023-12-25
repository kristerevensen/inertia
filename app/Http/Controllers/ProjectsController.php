<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index()
    {

        $projects = Project::paginate(2); // Or any other query
        return Inertia::render('Dashboard', ['projects' => $projects]);
    }

}
