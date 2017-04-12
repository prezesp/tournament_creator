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
      switch ($tournament->seeds)
      {
          case 16:
          {
              $this->generateRound("16r", $tournament);
          }
          case 16:
          case 8:
          {
              $this->generateRound("qt", $tournament);
          }
          case 16:
          case 8:
          case 4:
          {
              $this->generateRound("sf", $tournament);
          }
          case 16:
          case 8:
          case 4:
          case 2:
          {
              $this->generateRound("f", $tournament);
          }
          break;
      }
    }

    private function generateRound($stage, $tournament)
    {
      // nazwa => [liczba seedów, liczba meczów w rundzie]
      $stages = array(
        '16r' => [16, 8],
        'qt'  => [8,  4],
        'sf'  => [4,  2],
        'f'   => [2,  1]
      );

      // jeżeli jest to pierwsza runda -> generacja seedów z grup
      $isFirstRound = $tournament->seeds == $stages[$stage][0];
      if ($isFirstRound)
      {
        // Dla turnieju playoff od razu wypełnij pierwszą rudnę teamami
        if ($tournament->type == 'P')
        {
          $first_round = $this->teamsSeeding($tournament->teams());
        }
        // Dla turnieju z grupami seedy z grup
        else
        {
          $first_round = $this->groupsSeeding((int)$tournament->seeds, count($tournament->groups));
        }
      }
      // jeżeli jest to kolejna runda -> odczyt nazwy poprzedniej
      else
      {
        $prev = null;
        foreach ($stages as $st => $v)
        {
          if ($st == $stage)
          {
              break;
          }
          $prev = $st;
        }
      }

      // Utworzenie gier w rundzie
      for ($i = 0; $i < $stages[$stage][1]; $i++)
      {
          $game = new Game;
          $game->tournament()->associate($tournament);
          $game->stage = $stage;

          if ($isFirstRound)
          {
            if ($tournament->type == 'P')
            {
              $game->home()->associate($first_round[$i][0]);
              $game->away()->associate($first_round[$i][1]);
            }
            else {
              $game->home_seed = $first_round[$i][0];
              $game->away_seed = $first_round[$i][1];
            }
          }
          else
          {
            $game->home_seed = $prev." #".($i * 2);
            $game->away_seed = $prev." #".($i * 2 + 1);
          }
          $game->save();
      }

      // dodatkowy mecz dla finału (3 miejsce)
      if ($stage == 'f')
      {
        // Jezeli final jest jednoczesnie pierwsza rundą nie tworzymy meczu o 3.
        if (!$isFirstRound)
        {
          $game = new Game();
          $game->tournament()->associate($tournament);
          $game->stage = '3rd';
          $game->home_seed = "l ".$prev." #0";
          $game->away_seed = "l ".$prev." #1";
          $game->save();
        }
      }
    }

    private function groupsSeeding($seeds_count, $groups_count)
    {
      // sortowanie
      $seeds = [];
      for ($i=0; $i<$seeds_count; $i++)
      {
        $seeds[] = chr(ord('A') + ($i % $groups_count))." #".intval($i/$groups_count);
      }

      // utworzenie par 1 z n, 2 z n-1 (ale nie ta sama grupa)
      // dodajemy na zmiane do tylu koszyków, ile jest grup (g)
      // co g meczów odwracamy listę koszyków
      $buckets = [];
      for ($i=0; $i<$groups_count; $i++)
      {
        $buckets[$i] = [];
      }
      $b_ind = 0;
      while (!empty($seeds))
      {
        $team1 = array_shift($seeds);
        $g1 = explode(' ', $team1)[0];
        $i = count($seeds) - 1;
        do {
          $team2 = $seeds[$i--];
          $g2 = explode(' ', $team2)[0];
        }
        while ($groups_count != 1 && $g2 == $g1);
        array_splice($seeds, $i+1, 1);

        $buckets[$b_ind % $groups_count][] = array($team1, $team2);

        if ($b_ind++ % $groups_count == $groups_count - 1)
        {
          // switch
          $buckets = array_reverse($buckets);
        }
      }

      // łączymy wyniki
      $result = [];
      foreach ($buckets as $bucket)
      {
        $result = array_merge($result, $bucket);
      }
      return $result;
    }

    private function teamsSeeding($teams)
    {
      $bucket_count = count($teams) / 4;
      $buckets = [];
      for ($i=0; $i<$bucket_count; $i++)
      {
        $buckets[$i] = [];
      }
      $b_ind = 0;
      while (!empty($teams))
      {
        $team1 = array_shift($teams);
        $team2 = array_pop($teams);
        $buckets[$b_ind % $bucket_count][] = array($team1, $team2);

        if ($b_ind++ % $bucket_count == $bucket_count - 1)
        {
          // switch
          $buckets = array_reverse($buckets);
        }
      }
      $result = [];
      foreach ($buckets as $bucket)
      {
        $result = array_merge($result, $bucket);
      }
      return $result;
    }

}
