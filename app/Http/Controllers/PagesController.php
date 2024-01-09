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

        $fromDate = $request->input('from'); // Retrieve 'from' date from the request
        $toDate = $request->input('to');     // Retrieve 'to' date from the request

        // Metrics query with date filtering
        $metricsQuery = DataPage::query()
            ->where('project_code', $this->project_code);

        if ($fromDate && $toDate) {
            $metricsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $metrics = $metricsQuery->selectRaw('
                count(distinct(session_id)) as sessions, count(*) as pageviews,
                count(entrance) as entrances,
                count(exits) as exits,
                count(distinct(bounce)) as bounce
                ')
            ->first();

        // Pages query with date filtering
        $pagesQuery = DataPage::query()
            ->where('project_code', $this->project_code);

        if ($fromDate && $toDate) {
            $pagesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $pages = $pagesQuery->selectRaw('COUNT(url) as pageviews, SUM(bounce) as bounce, SUM(entrance) as entrances, url, project_code, url_code')
            ->groupBy('project_code', 'url', 'url_code')
            ->orderBy('pageviews','desc')
            ->paginate(10);

        return Inertia::render('Pages', [
            'pages' => $pages,
            'metrics' => $metrics
        ]);
    }
}
