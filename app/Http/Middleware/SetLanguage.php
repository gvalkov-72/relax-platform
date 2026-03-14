<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Language;

class SetLanguage
{
    public function handle($request, Closure $next)
    {
        $code = $request->segment(1);

        $language = Language::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (! $language) {
            $language = Language::where('is_default', true)->first();
        }

        if ($language) {
            app()->setLocale($language->code);
            view()->share('currentLanguage', $language);
        }

        return $next($request);
    }
}