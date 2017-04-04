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
      return $this->home;
    }
    else if ($this->home_score < $this->away_score)
    {
      return $this->away;
    }
    return null;
  }
}
