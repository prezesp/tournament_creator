<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class UserController extends Controller
{
  public function search($username)
  {
    return User::where('name', 'like', $username.'%')->where('name', '!=', Auth::user()->name)->get();
  }

  public function show($userId) 
  {
    $user = User::find($userId);
    $tournaments = $user->tournaments()->orderBy('id', 'desc')->paginate(10); 
    return view('user.show', ['user' => $user, 'tournaments' => $tournaments]);
  }
}
