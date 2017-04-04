<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

class SportController extends Controller
{
    public function index(Request $request)
    {
      $sports = array(
        'american_football',
        'badminton',
        'baseball',
        'basketball',
        'beach_volleyball',
        'boxing',
        'cricket',
        'football',
        'handball',
        'ice_hockey',
        'rugby',
        'snooker',
        'swimming',
        'table_tennis',
        'tennis',
        'volleyball',

        'other',
      );

      $sports_array = [];
      foreach ($sports as $s) {
        //$sports[$k] = Lang::get('sports.'.$v);
        array_push($sports_array, array('id' => $s, 'name' => Lang::get('sports.'.$s)));
      }

      //sort($sports);
      return $sports_array;
    }
}
