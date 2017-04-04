<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Game;
use App\Group;
use App\Team;
use App\Tournament;

class GameController extends Controller
{
    public function update($gameId, Request $request)
    {
      if (Auth::check())
      {
        $game = Game::find($gameId);

        if (!empty($request->input('home_id')))
        {
          $game->home()->associate(Team::find($request->input('home_id')));
        }
        if (!empty($request->input('away_id')))
        {
          $game->away()->associate(Team::find($request->input('away_id')));
        }
        $game->game_time = $request->input('game_time');
        $game->home_score = $request->input('home_score');
        $game->away_score = $request->input('away_score');

        $game->save();
        if (config('app.debug'))
        {
          usleep(300000);
        }

        if($request->ajax())
        {
          $tournament = Tournament::find(empty($game->tournament->id) ? $game->group->tournament->id : $game->tournament->id);
          return $this->ajaxResponse($request, $tournament);
        }
        return "OK";
      }
      else
      {
        return Response::json(['error' => 'Error msg'], 401);
      }
    }

    public function store(Request $request)
    {
      if (Auth::check())
      {
        $group = Group::find($request->input('group_id'));

        $game = new Game;
        $game->group()->associate($group);
        $game->stage = "g";

        $game->save();
        if (config('app.debug'))
        {
          usleep(300000);
        }

        if($request->ajax())
        {
          $tournament = Tournament::find($group->tournament->id);
          return $this->ajaxResponse($request, $tournament);
        }
        return "OK";
      }
      else
      {
        return Response::json(['error' => 'Error msg'], 401);
      }
    }

    public function destroy($gameId, Request $request)
    {
      if (Auth::check())
      {
        $game = Game::find($gameId);
        $tournament = Tournament::find($game->group->tournament->id);

        $game->delete();

        if($request->ajax())
        {
          return $this->ajaxResponse($request, $tournament);
        }
        return "OK";
      }
      else
      {
        return Response::json(['error' => 'Error msg'], 401);
      }
    }

    private function ajaxResponse(Request $request, $tournament)
    {
      // Request musi zawierać dwa dodatkowe pola
      //  - view      określa jaki widok ma zostać załadowany
      //  - section   okresla, którą sekcję widoku załadować i zwrócić (domyślnie mod-content)
      $view = 'tournament.types.'.$request->input('_view');
      $section = !empty($request->input('_section')) ? $request->input('_section') : 'mod-content';
      $sections = view($view, ['tournament' => $tournament])->renderSections();
      return $sections[$section];
    }
}
