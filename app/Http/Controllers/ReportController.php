<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Task;
use App\Models\FollowUp;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);

        return view('reports.index', $data);
    }
    private function getReportData(Request $request)
    {
        $tenantId = auth()->user()->tenant_id;

        $query = Lead::where('tenant_id', $tenantId);

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        /*
        |--------------------------------------------------------------------------
        | KPI Cards
        |--------------------------------------------------------------------------
        */

        $totalLeads = (clone $query)->count();

        $wonLeads = (clone $query)
            ->where('status', 'Won')
            ->count();

        $lostLeads = (clone $query)
            ->where('status', 'Lost')
            ->count();

        $pendingTasks = Task::where('tenant_id', $tenantId)
            ->where('status', 'Pending')
            ->count();

        $pendingFollowUps = FollowUp::where('tenant_id', $tenantId)
            ->where('status', 'Pending')
            ->count();

        $conversionRate = $totalLeads > 0
            ? round(($wonLeads / $totalLeads) * 100, 2)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Revenue Analytics
        |--------------------------------------------------------------------------
        */

        $totalRevenue = (clone $query)
            ->where('status', 'Won')
            ->sum('value');

        $expectedRevenue = (clone $query)
            ->whereNotIn('status', ['Won', 'Lost'])
            ->sum('value');

        $averageDealValue = (clone $query)
            ->where('status', 'Won')
            ->avg('value') ?? 0;

        $largestDeal = (clone $query)
            ->where('status', 'Won')
            ->max('value') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Sales Funnel
        |--------------------------------------------------------------------------
        */

        $statuses = [
            'New',
            'Contacted',
            'Qualified',
            'Proposal',
            'Negotiation',
            'Won',
            'Lost'
        ];

        $statusChart = [];

        foreach ($statuses as $status) {

            $statusChart[$status] = (clone $query)
                ->where('status', $status)
                ->count();

        }

        /*
        |--------------------------------------------------------------------------
        | Monthly Leads
        |--------------------------------------------------------------------------
        */

        $monthlyLeads = [];

        for ($i = 1; $i <= 12; $i++) {

            $monthlyLeads[] = (clone $query)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $i)
                ->count();

        }

        /*
        |--------------------------------------------------------------------------
        | Monthly Revenue
        |--------------------------------------------------------------------------
        */

        $monthlyRevenue = [];

        for ($i = 1; $i <= 12; $i++) {

            $monthlyRevenue[] = (clone $query)
                ->where('status', 'Won')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $i)
                ->sum('value');

        }

        /*
        |--------------------------------------------------------------------------
        | Lead Source Chart
        |--------------------------------------------------------------------------
        */

        $sourceChart = (clone $query)
            ->select('source', DB::raw('COUNT(*) as total'))
            ->groupBy('source')
            ->pluck('total', 'source');

        /*
        |--------------------------------------------------------------------------
        | Recent Won Deals
        |--------------------------------------------------------------------------
        */

        $recentWonDeals = (clone $query)
            ->where('status', 'Won')
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        $users = User::where('tenant_id', $tenantId)
            ->orderBy('name')
            ->get();

        return [

            'totalLeads'        => $totalLeads,
            'wonLeads'          => $wonLeads,
            'lostLeads'         => $lostLeads,
            'pendingTasks'      => $pendingTasks,
            'pendingFollowUps'  => $pendingFollowUps,
            'conversionRate'    => $conversionRate,

            'totalRevenue'      => $totalRevenue,
            'expectedRevenue'   => $expectedRevenue,
            'averageDealValue'  => round($averageDealValue),
            'largestDeal'       => $largestDeal,
            'monthlyRevenue'    => $monthlyRevenue,

            'statusChart'       => $statusChart,
            'monthlyLeads'      => $monthlyLeads,
            'sourceChart'       => $sourceChart,
            'recentWonDeals'    => $recentWonDeals,
            'users'             => $users,

        ];
    }
    public function filter(Request $request)
    {
        $data = $this->getReportData($request);

        return response()->json([
            'totalLeads'       => $data['totalLeads'],
            'wonLeads'         => $data['wonLeads'],
            'lostLeads'        => $data['lostLeads'],
            'pendingTasks'     => $data['pendingTasks'],
            'pendingFollowUps' => $data['pendingFollowUps'],
            'conversionRate'   => $data['conversionRate'],
            'statusChart'      => $data['statusChart'],
            'monthlyLeads'     => $data['monthlyLeads'],

            'sourceChart' => [
                'labels' => $data['sourceChart']->keys(),
                'values' => $data['sourceChart']->values(),
            ],

            'recentWonDeals' => $data['recentWonDeals'],
            'totalRevenue'      => $data['totalRevenue'],
            'expectedRevenue'   => $data['expectedRevenue'],
            'averageDealValue'  => $data['averageDealValue'],
            'largestDeal'       => $data['largestDeal'],
            'monthlyRevenue'    => $data['monthlyRevenue'],
        ]);
    }
    // public function index(Request $request)
    // {
    //     $tenantId = auth()->user()->tenant_id;

    //     // KPI Cards
    //     $totalLeads = Lead::where('tenant_id', $tenantId)->count();

    //     $wonLeads = Lead::where('tenant_id', $tenantId)
    //         ->where('status', 'Won')
    //         ->count();

    //     $lostLeads = Lead::where('tenant_id', $tenantId)
    //         ->where('status', 'Lost')
    //         ->count();

    //     $pendingTasks = Task::where('tenant_id', $tenantId)
    //         ->where('status', 'Pending')
    //         ->count();

    //     $pendingFollowUps = FollowUp::where('tenant_id', $tenantId)
    //         ->where('status', 'Pending')
    //         ->count();

    //     $conversionRate = $totalLeads > 0
    //         ? round(($wonLeads / $totalLeads) * 100, 2)
    //         : 0;

    //     // Sales Funnel
    //     $statusChart = [
    //         'New' => Lead::where('tenant_id', $tenantId)->where('status', 'New')->count(),
    //         'Contacted' => Lead::where('tenant_id', $tenantId)->where('status', 'Contacted')->count(),
    //         'Qualified' => Lead::where('tenant_id', $tenantId)->where('status', 'Qualified')->count(),
    //         'Proposal' => Lead::where('tenant_id', $tenantId)->where('status', 'Proposal')->count(),
    //         'Negotiation' => Lead::where('tenant_id', $tenantId)->where('status', 'Negotiation')->count(),
    //         'Won' => Lead::where('tenant_id', $tenantId)->where('status', 'Won')->count(),
    //         'Lost' => Lead::where('tenant_id', $tenantId)->where('status', 'Lost')->count(),
    //     ];

    //     // Monthly Leads
    //     $monthlyLeads = [];

    //     for ($i = 1; $i <= 12; $i++) {

    //         $monthlyLeads[] = Lead::where('tenant_id', $tenantId)
    //             ->whereYear('created_at', now()->year)
    //             ->whereMonth('created_at', $i)
    //             ->count();
    //     }

    //     // Lead Source Report
    //     $sourceChart = Lead::where('tenant_id', $tenantId)
    //         ->select('source', DB::raw('COUNT(*) as total'))
    //         ->groupBy('source')
    //         ->pluck('total', 'source');

    //     // Recent Won Deals
    //     $recentWonDeals = Lead::where('tenant_id', $tenantId)
    //         ->where('status', 'Won')
    //         ->latest()
    //         ->take(10)
    //         ->get();

    //     return view('reports.index', compact(
    //         'totalLeads',
    //         'wonLeads',
    //         'lostLeads',
    //         'pendingTasks',
    //         'pendingFollowUps',
    //         'conversionRate',
    //         'statusChart',
    //         'monthlyLeads',
    //         'sourceChart',
    //         'recentWonDeals'
    //     ));
    // }
}
