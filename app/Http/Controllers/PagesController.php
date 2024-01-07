<?php

namespace App\Http\Controllers;

use App\Models\DataPage;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    protected $project_code = "P00000001";

    public function index(Request $request)
    {

        $pages = DataPage::query()
            ->where('project_code', $this->project_code)
            ->selectRaw('COUNT(url) as pageviews, SUM(bounce) as bounce, SUM(entrance) as entrances, url, project_code, url_code')
            ->groupBy('project_code', 'url', 'url_code')
            ->orderBy('pageviews','desc')
            ->paginate(10);

        return Inertia::render('Pages', ['pages' => $pages]);
    }
}
