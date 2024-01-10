<?php

namespace App\Http\Controllers;

use App\Charts\PagesTrend;
use App\Models\DataPage;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class PagesController extends Controller
{
    protected $project_code = "P00000001";

    public function index(Request $request, PagesTrend $chart)
    {

        $fromDate = $request->input('from'); // Retrieve 'from' date from the request
        $toDate = $request->input('to');     // Retrieve 'to' date from the request






        ### MetricsQuery ###
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
            ->orderBy('pageviews', 'desc')
            ->paginate(10);

        // Append existing query parameters to the pagination links
        $pages->appends([
            'from' => $fromDate,
            'to' => $toDate
        ]);



        ### Pageview Query ###
        // Pageviews query with date filtering for chart
        $pageviewsQuery = DataPage::query()
            ->where('project_code', $this->project_code);

        if ($fromDate && $toDate) {
            $pageviewsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $chartPageviews = $pageviewsQuery->selectRaw('
            count(url) as pageviews,
            date(created_at) as date
            ')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->keyBy('date'); // Key the collection by date for easy merging

        // Generate a date series for the given range
        $datePeriod = new \DatePeriod(
            new \DateTime($fromDate),
            new \DateInterval('P1D'),
            (new \DateTime($toDate))->modify('+1 day')
        );

        // Prepare a collection with zero pageviews for each date
        $allDatesPageviews = new Collection();
        foreach ($datePeriod as $date) {
            $formattedDate = $date->format('Y-m-d');
            $allDatesPageviews[$formattedDate] = ['date' => $formattedDate, 'pageviews' => 0];
        }

        // Merge the collections
        $finalPageviews = $allDatesPageviews->merge($chartPageviews)->values();

        $pageviews = response()->json($finalPageviews);

        return Inertia::render('Pages', [
            'pages' => $pages,
            'metrics' => $metrics,
            'pageviews' => $pageviews
        ]);
    }

    public function show(Request $request, $url)
    {
        $fromDate = $request->input('from'); // Retrieve 'from' date from the request
        $toDate = $request->input('to');     // Retrieve 'to' date from the request


        ### MetricsQuery ###
        // Metrics query with date filtering
        $metricsQuery = DataPage::query()
            ->where('project_code', $this->project_code)
            ->where('url_code', $url);

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

        ### MetricsQuery ###
        // Metrics query with date filtering
        $pageQuery = DataPage::query()
            ->where('project_code', $this->project_code)
            ->where('url_code', $url);

        if ($fromDate && $toDate) {
            $pageQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $pageData = $pageQuery->selectRaw('
                *
                ')
            ->first();

        ### Pageview Query ###
        // Pageviews query with date filtering for chart
        $pageviewsQuery = DataPage::query()
            ->where('project_code', $this->project_code)
            ->where('url_code', $url);

        if ($fromDate && $toDate) {
            $pageviewsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $chartPageviews = $pageviewsQuery->selectRaw('
            count(url) as pageviews,
            date(created_at) as date
            ')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->keyBy('date'); // Key the collection by date for easy merging

        // Generate a date series for the given range
        $datePeriod = new \DatePeriod(
            new \DateTime($fromDate),
            new \DateInterval('P1D'),
            (new \DateTime($toDate))->modify('+1 day')
        );

        // Prepare a collection with zero pageviews for each date
        $allDatesPageviews = new Collection();
        foreach ($datePeriod as $date) {
            $formattedDate = $date->format('Y-m-d');
            $allDatesPageviews[$formattedDate] = ['date' => $formattedDate, 'pageviews' => 0];
        }

        // Merge the collections
        $finalPageviews = $allDatesPageviews->merge($chartPageviews)->values();

        $pageviews = response()->json($finalPageviews);


        return Inertia::render('PageShow', [
            'pageviews' => $pageviews,
            'metrics' => $metrics,
            'page' => $pageData
        ]);
    }
}
