<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $myTournaments = Auth::user()->tournaments()->orderBy('id', 'desc')->paginate(10); 
    $moderatedTournaments = Auth::user()->tournamentsAsModerator()->orderBy('id', 'desc')->paginate(10);
    $moderatedTournaments->withPath('?moderated');
    return view('home', ['myTournaments' => $myTournaments, 'moderatedTournaments' => $moderatedTournaments]);
  }
}
