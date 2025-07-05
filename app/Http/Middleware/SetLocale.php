<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Pega o locale da sessão, ou usa o default da config/app.php
        $locale = Session::get('locale', config('app.locale'));

        // Seta o locale do app
        App::setLocale($locale);

        \Log::info("Locale setado para: {$locale}");

        return $next($request);
    }
}
