<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use URL;
use Cookie;

class LocaleController extends Controller {

    public function setLocale($locale = 'en')
    {
        if (! in_array($locale,['en','es','pl']))
        {
            $locale = 'en';
        }
        session(['lang' => $locale]);
        if (Auth::check())
        {
          $user = Auth::user();
          $user->locale = $locale;
          $user->save();
        }
        return redirect(url(URL::previous()));
    }
}
