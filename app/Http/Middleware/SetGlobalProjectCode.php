<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetGlobalProjectCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $current_team_id = Auth::user()->current_team_id;
            $project_code = DB::table('projects')->select('project_code')->where('team_id', $current_team_id)->first() ?? null;
            //dd($project_code);
            if ($project_code) {
                // Assuming you have a method to get the project code from the team

                Session::put('selected_project_code', $project_code);
            }
        }

        return $next($request);
    }
}
