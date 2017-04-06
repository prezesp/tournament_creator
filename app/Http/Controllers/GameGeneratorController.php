<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Game;

class GameGeneratorController extends Controller
{
    //
    public function generateGroupGames($group, $teams)
    {
      // podziel na pół.
      $len = count($teams);

      $home = array_slice($teams, 0, $len / 2);
      $away = array_slice($teams, $len / 2);
      $away = array_reverse($away);

      $dummy = 'dummy';
      if (count($home) < count($away))
      {
        array_push($home, $dummy);
      }

      // Wygenerowanie rund
      $rounds = array();
      // dla każdej rundy
      for ($i=0; $i< count($away) + count($home) - 1; $i++)
      {
        // zamień strony i połącz w pary drużyny z grup
        if ($i % 2 == 0)
        {
          $pairs = array_map(null, $home, $away);
        }
        else
        {
          $pairs = array_map(null, $away, $home);
        }
        array_push($rounds, $pairs);


        // zamiana drużyn w grupach
        $item1 = array_shift($away);
        $item2 = array_pop($home);

        array_push($away, $item2);
        array_splice($home, 1, 0, array($item1));
      }

      // Utworzenie gier
      $games = array();
      foreach ($rounds as $round)
      {
        foreach ($round as $g)
        {
          if ($g[0] != $dummy && $g[1] != $dummy)
          {
            $game = new Game;
            $game->home()->associate($g[0]);
            $game->away()->associate($g[1]);
            $game->group()->associate($group);
            $game->stage = "g";
            $game->save();
            array_push($games, $game);
          }
        }
      }

      return $games;
    }

    public function generatePlayoffGames($tournament)
    {
      $games = array();

      switch ($tournament->seeds) {
          case 16: {
              // quarterfinals
              for ($i = 0; $i < 8; $i++) {
                  $game = new Game;
                  $game->tournament()->associate($tournament);
                  $game->stage = "16r";
                  $game->save();
                  array_push($games, $game);
              }
          }
          case 16:
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
          case 16:
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
          case 16:
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
