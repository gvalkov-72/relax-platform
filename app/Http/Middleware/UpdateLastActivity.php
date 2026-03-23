<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateLastActivity
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            $userId = $request->user()->id;
            $now = now();

            try {
                DB::table('users')
                    ->where('id', $userId)
                    ->update(['last_activity' => $now]);

                Log::info('Last activity updated', ['user_id' => $userId, 'time' => $now]);
            } catch (\Exception $e) {
                Log::error('Failed to update last_activity', ['user_id' => $userId, 'error' => $e->getMessage()]);
            }
        } else {
            Log::debug('UpdateLastActivity: no authenticated user');
        }

        return $next($request);
    }
}