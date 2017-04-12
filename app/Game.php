<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
  /**
   * attributes
   */
  protected $fillable = [
    'home_score', 'away_score'
  ];


  public function home()
  {
    return $this->belongsTo('App\Team', 'home_id');
  }

  public function away()
  {
    return $this->belongsTo('App\Team', 'away_id');
  }

  public function group()
  {
    return $this->belongsTo('App\Group');
  }

  public function tournament()
  {
    return $this->belongsTo('App\Tournament');
  }

  public function winner()
  {
    if ($this->home_score > $this->away_score)
    {
      if (empty($this->home))
      {
        return $this->tournament->getSeed($this->home_seed);
      }
      return $this->home;
    }
    else if ($this->home_score < $this->away_score)
    {
      if (empty($this->away))
      {
        return $this->tournament->getSeed($this->away_seed);
      }
      return $this->away;
    }
    return null;
  }

  public function loser()
  {
    if ($this->home_score < $this->away_score)
    {
      if (empty($this->home))
      {
        return $this->tournament->getSeed($this->home_seed);
      }
      return $this->home;
    }
    else if ($this->home_score > $this->away_score)
    {
      if (empty($this->away))
      {
        return $this->tournament->getSeed($this->away_seed);
      }
      return $this->away;
    }
    return null;
  }

  public function isOver()
  {
    if ($this->home_score == NULL || $this->away_score == NULL)
    {
      return false;
    }
    return true;
  }
}
