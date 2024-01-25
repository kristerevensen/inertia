<?php

namespace App\Http\Controllers;

use App\Charts\PagesTrend;
use App\Models\DataPage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PagesController extends Controller
{
    protected $project_code;


    public function index(Request $request, PagesTrend $chart)
    {
        $teamID = DB::table('users')
            ->where('id', Auth::user()->id)
            ->select('current_team_id')
            ->first()
            ->current_team_id;
        $this->project_code = $this->getSelectedProject($teamID);

        $fromDate = $request->input('from'); // Retrieve 'from' date from the request
        $toDate = $request->input('to');     // Retrieve 'to' date from the request

        if (! $fromDate || ! $toDate) {
            // Set $toDate to yesterday, as we are excluding today
            $toDate = Carbon::yesterday()->toDateString();

            // Set $fromDate to 28 days before $toDate
            $fromDate = Carbon::yesterday()->subDays(27)->toDateString();
        }

        //DB::enableQueryLog();

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
                count(bounce) as bounce
                ')
            ->first();


        // Pages query with date filtering
        $pagesQuery = DataPage::query()
            ->where('project_code', $this->project_code);

        if ($fromDate && $toDate) {
            $pagesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $pages = $pagesQuery->selectRaw('
                COUNT(url) as pageviews,
                sum(bounce) as bounces,
                sum(entrance) as entrances,
                sum(exits) as exits,
                url,
                project_code,
                url_code
                ')
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

        //dd($chartPageviews);

        return Inertia::render('Pages/Index', [
            'pages' => $pages,
            'metrics' => $metrics,
            'pageviews' => $pageviews
        ]);
    }
    public function parseURL($url)
    {
        $parsedUrl = parse_url($url);
        $pathname = $parsedUrl['path'] ?? ''; // $pathname will be "/page"
        return $pathname;
    }
    function getUrlParameters($url) {
        // Parse the URL and return its components
        $parsedUrl = parse_url($url);

        // Extract the query string
        $queryString = $parsedUrl['query'] ?? '';

        // Parse the query string into an associative array
        $queryParams = [];
        parse_str($queryString, $queryParams);
        return array_keys($queryParams);
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
            'page' => $pageData,
            'params' => $this->getUrlParameters($pageData->url),
            'changes' => $this->getChanges($pageData->url),
            'sources' => $this->getSources($pageData->url),
        ]);
    }
    public function getSources($url)
    {
        $rawSources = DB::table('data_pages')
            ->where('project_code', $this->project_code)
            ->where('url', $url)
            ->select(
                'referrer',
                DB::raw('count(*) as count'),
                DB::raw('count(*) as pageviews'),
                DB::raw('count(distinct(session_id)) as sessions'),
                DB::raw('sum(bounce) as bounces'),
                DB::raw('sum(entrance) as entrances'),
                DB::raw('sum(exits) as exits')
            )
            ->groupBy('referrer')
            ->get();

        $categorizedSources = $rawSources->mapToGroups(function ($item) {
            $sourceType = $this->categorizeSource($item->referrer);
            return [$sourceType => $item];
        });

        $summarizedSources = $categorizedSources->map(function ($group, $sourceType) {
            return [
                'source_type' => $sourceType,
                'count' => $group->sum('count'),
                'pageviews' => $group->sum('pageviews'),
                'sessions' => $group->sum('sessions'),
                'bounces' => $group->sum('bounces'),
                'entrances' => $group->sum('entrances'),
                'exits' => $group->sum('exits'),
            ];
        });

        return $summarizedSources;
    }
    private function categorizeSource($referrer)
    {
        if (empty($referrer)) {
            return 'Direct Traffic';
        }

        $parsedUrl = parse_url($referrer);
        $host = strtolower($parsedUrl['host'] ?? '');

        // Define arrays of hostnames for different categories
        $searchEngines = ['google', 'bing', 'yahoo', 'baidu', 'duckduckgo'];
        $socialMedia = ['facebook', 'twitter', 'linkedin', 'instagram', 'pinterest'];

        // Check if the referrer matches any known search engines
        foreach ($searchEngines as $searchEngine) {
            if (strpos($host, $searchEngine) !== false) {
                return 'Organic Search';
            }
        }

        // Check if the referrer matches any known social media platforms
        foreach ($socialMedia as $social) {
            if (strpos($host, $social) !== false) {
                return 'Social Media';
            }
        }
        // Check for Paid Search (basic approach, might require UTM parameter checks)
        if (strpos($referrer, 'utm_medium=cpc') !== false || strpos($referrer, 'gclid=') !== false) {
            return 'Paid Search';
        }

        // Add more checks here for other categories like 'Paid Search', 'Referral', etc.

        // Default category
        return 'Referral Traffic';
    }
    public function getChanges($url)
    {
        $changes = DB::table('data_pages')
            ->where('project_code', $this->project_code)
            ->where('url', $url)
            ->selectRaw('
                distinct(content_hash),
                created_at
                ')
            ->orderBy('created_at', 'desc')
            ->groupBy('content_hash', 'created_at')
            ->get();

        return $changes;
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
