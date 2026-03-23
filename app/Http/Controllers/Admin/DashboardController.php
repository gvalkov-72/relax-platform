<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Statistic;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $onlineUsers = User::where('last_activity', '>=', now()->subMinutes(2))
            ->select('id', 'name', 'email', 'last_activity')
            ->get();
        $onlineUsersCount = $onlineUsers->count();

        // Статистики от таблицата statistics
        $totalSessions = Statistic::count();
        $avgDuration = Statistic::avg('duration') ?? 0;
        $topSessionType = Statistic::select('session_type', DB::raw('count(*) as count'))
            ->groupBy('session_type')
            ->orderByDesc('count')
            ->first();
        $topSessionType = $topSessionType ? $topSessionType->session_type : __('dashboard.none');

        // Данни за графиката – активни потребители през последните 7 дни
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartLabels[] = $date;
            $chartData[] = User::whereDate('last_activity', $date)->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'onlineUsers',
            'onlineUsersCount',
            'totalSessions',
            'avgDuration',
            'topSessionType',
            'chartLabels',
            'chartData'
        ));
    }
}