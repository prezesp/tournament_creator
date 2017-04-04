<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;
use Session;
use App;
use Config;

class Locale {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
          App::setLocale(Auth::user()->locale);
        }
        else
        {
          $locale = $request->cookie('locale', Config::get('app.locale'));
          App::setLocale(session('lang') == null ? 'en' : session('lang'));
        }



        return $next($request);
    }

}
