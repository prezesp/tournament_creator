<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Team;
use App\RankingPosition;

class Group extends Model
{
  public $timestamps = false;

  /**
   * attributes
   */
  protected $fillable = [
    'name'
  ];

  public function tournament()
  {
    return $this->belongsTo('App\Tournament');
  }

  public function teams()
  {
    return $this->hasMany('App\Team');
  }

  public function games()
  {
    return $this->hasMany('App\Game');
  }

  private function assign_points($rank, $in_plus)
  {
    if ($in_plus > 0)
      $rank->points += $this->tournament->win_pts;
    else if ($in_plus < 0)
      $rank->points += $this->tournament->loss_pts;
    else
      $rank->points += $this->tournament->draw_pts;
  }

  public function ranking()
  {
    $ranking_list = array();
    foreach ($this->teams as $team)
    {
      $rank = new RankingPosition;
      $rank->team = $team;
      $rank->points = 0;
      $rank->balance_plus = 0;
      $rank->balance_minus = 0;
      $rank->game_count = 0;
      foreach ($this->games->where('home', $team) as $game)
      {
        if ($game->home_score == NULL)
          continue;
        $rank->balance_plus += $game->home_score;
        $rank->balance_minus += $game->away_score;

        $in_plus = $game->home_score - $game->away_score;
        $this->assign_points($rank, $in_plus);
        $rank->game_count += 1;
      }

      foreach ($this->games->where('away', $team) as $game)
      {
        if ($game->home_score == NULL)
          continue;
        $rank->balance_plus += $game->away_score;
        $rank->balance_minus += $game->home_score;

        $in_plus = $game->away_score - $game->home_score;
        $this->assign_points($rank, $in_plus);
        $rank->game_count += 1;
      }
      array_push($ranking_list, $rank);
    }
    
    // sortowanie
    usort($ranking_list, function($a, $b)
    {
      if ($a->points == $b->points)
      {
        $a_ratio = $a->balance_plus - $a->balance_minus;
        $b_ratio = $b->balance_plus - $b->balance_minus;

        if ($a_ratio == $b_ratio)
        {
          return $b->balance_minus - $a->balance_plus;
        }
        return $b_ratio - $a_ratio;
      }
      return $b->points - $a->points;
    });

    return $ranking_list;
  }
}
