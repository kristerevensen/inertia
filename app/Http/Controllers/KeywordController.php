<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class KeywordController extends Controller
{
    protected $project_code;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->project_code = $this->getSelectedProject(Auth::user()->current_team_id);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Keywords/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keyword $keyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keyword $keyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        //
    }

    public function getSelectedProject($teamID)
    {
        $project = DB::table('projects')
            ->where('team_id', $teamID)
            ->select('project_code')
            ->first();

        if (!$project) {
            return redirect()->route('dashboard')->with('error', 'You have no projects');
        }

        return $project->project_code;
    }
}
