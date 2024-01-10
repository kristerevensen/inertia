<?php
namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\DataPage; // Assuming DataPage is your model
use Illuminate\Http\Request;

class PagesTrend
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Request $request): array
    {
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Fetch data from DataPage model with date filtering
        $pageviewData = DataPage::query()
            ->where('project_code', 'your_project_code') // replace with actual project code
            ->when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                return $query->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->selectRaw('count(url) as pageviews, date(created_at) as date')
            ->groupBy('date') // Group by date only
            ->orderBy('date', 'ASC')
            ->get();

        // Extracting dates and pageviews for the chart
        $dates = $pageviewData->pluck('date')->toArray();
        $pageviews = $pageviewData->pluck('pageviews')->toArray();

        return $this->chart->lineChart()
            ->setTitle('Pageviews Trend')
            ->setSubtitle('Tracking pageviews over time.')
            ->addArea('Pageviews', $pageviews)
            ->setXAxis($dates)
            ->toVue();
    }
}
