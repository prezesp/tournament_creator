<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
  // TODO osobny controller (Home?)
  $t_c = App\Tournament::count();
  $g_c = App\Game::count();
  $tm_c = App\Team::count();
  $u_c = App\User::count();
  return view('index', ['tournaments' => $t_c, 'games' => $g_c,  'teams' => $tm_c, 'users' => $u_c]);
});

Auth::routes();

Route::get('user/change', 'Auth\ChangePasswordController@index');
Route::post('user/change', [
    'as' => 'user.change',
    'uses' => 'Auth\ChangePasswordController@postCredentials'
]);

Route::get('/home', 'HomeController@index');

Route::get('/tournament/search', [
    'as' => 'tournament.search',
    'uses' => 'TournamentController@search'
]);

Route::get('/tournament/{tournament}/export/{type?}', [
    'as' => 'tournament.export',
    'uses' => 'TournamentController@export'
]);

Route::resource('tournament', 'TournamentController');

Route::resource('game', 'GameController');

Route::resource('comment', 'CommentController');

Route::resource('sport', 'SportController');




Route::get('/users/search/{username}', 'UserController@search')->middleware('auth');

Route::get('locale/{locale?}',
    [
        'as' => 'locale.setlocale',
        'uses' => 'LocaleController@setLocale'
    ]);
