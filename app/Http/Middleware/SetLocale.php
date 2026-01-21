<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get('locale', config('app.locale'));

        if ($request->has('lang')) {
            $requested = $request->get('lang');
            if (in_array($requested, ['fr', 'en', 'ar'], true)) {
                $locale = $requested;
                $request->session()->put('locale', $locale);
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
