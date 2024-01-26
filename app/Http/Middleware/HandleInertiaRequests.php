<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [

            // Lazily adding Ziggy configuration
            'ziggy' => fn () => array_merge((new Ziggy)->toArray(), [
                'location' => $request->url(),
            ]),
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'errors' => fn () => $request->session()->get('errors') ? $request->session()->get('errors')->getBag('default')->getMessages() : (object) [],
            'message' => fn () => $request->session()->get('message'),
            'user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email', 'profile_photo_path', 'current_team_id')
                : null,
            'success' => fn () => $request->session()->get('success'),

            // Lazily adding projects data
            'projects' => fn () => auth()->user()
                ? Project::where('owner_id', auth()->id())->get()
                : null,

            // Add more shared data here if needed
        ]);
    }
    public function handle($request, Closure $next)
    {
        // Share global project data with every Inertia response
         return parent::handle($request, $next);
    }
}
