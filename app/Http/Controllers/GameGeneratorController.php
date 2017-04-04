<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Game;

class GameGeneratorController extends Controller
{
    //
    public function generateGroupGames($group)
    {
      $games = array();
      $visited = array();
      foreach ($group->teams as $home) {
          $i = 0;
          foreach ($group->teams as $away) {
              if ($home != $away and !in_array($away, $visited)) {
                  $game = new Game;
                  //$game->home_score = 0;
                  //$game->away_score = 0;

                  if ($i++ % 2 == 0) {
                      $game->home()->associate($home);
                      $game->away()->associate($away);
                  } else {
                      $game->home()->associate($away);
                      $game->away()->associate($home);
                  }
                  $game->group()->associate($group);
                  $game->stage = "g";
                  //$game->Stage = 0; // group stage
                  //$game->IsFinal = 0;
                  //$game->Tournament = new Tournament();
                  //$game->Tournament->Id = $group->TournamentId;
                  $game->save();
                  array_push($games, $game);
              }
          }
          array_push($visited, $home);
        }
        return $games;
    }


    public function generatePlayoffGames($tournament)
    {
      $games = array();
      
      switch ($tournament->seeds) {
          case 8: {
              // quarterfinals
              for ($i = 0; $i < 4; $i++) {
                  $game = new Game;
                  $game->tournament()->associate($tournament);
                  $game->stage = "qt";
                  $game->save();
                  array_push($games, $game);
              }
          }
          case 8:
          case 4: {
              // semifinals
              for ($i = 0; $i < 2; $i++) {
                  $game = new Game;
                  $game->tournament()->associate($tournament);
                  $game->stage = "sf";
                  $game->save();
                  array_push($games, $game);
              }
          }
          case 8:
          case 4:
          case 2: {
              // final and 3rd place
             for ($i = 0; $i < 2; $i++) {
                  $game = new Game();
                  $game->tournament()->associate($tournament);
                  $game->stage = $i == 0 ? '3rd' : 'f';
                  $game->save();
                  array_push($games, $game);
              }

          } break;
      }
      return $games;
    }

}
