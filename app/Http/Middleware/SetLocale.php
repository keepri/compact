<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\SupportedLocale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionLocale = Session::get('locale');

        if (! is_string($sessionLocale)) {
            return $next($request);
        }

        $locale = SupportedLocale::tryFrom($sessionLocale) ?? SupportedLocale::En;

        App::setLocale($locale->value);
        Date::setLocale($locale->value);
        Session::put('locale', $locale->value);

        return $next($request);
    }
}
