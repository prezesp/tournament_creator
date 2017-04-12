<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Game;

class Tournament extends Model
{
    /**
     * 'created_at' & 'updated_at' not needed
     */
    public $timestamps = false;

    /**
     * attributes
     */
    protected $fillable = [
      'name', 'description', 'date', 'type', 'seeds', 'win_pts', 'draw_pts', 'loss_pts'
    ];

    public function groups()
    {
      return $this->hasMany('App\Group');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function moderators()
    {
      return $this->belongsToMany('App\User', 'tournaments_moderators');
    }

    public function games()
    {
      return $this->hasMany('App\Game');
    }

    public function comments()
    {
      return $this->hasMany('App\Comment');
    }

    public function type_longname()
    {
      return array('L' => 'League',
        'P' => 'Playoff',
        'GP' => 'Group & PO',
        'DL' => 'Dynamic League')[$this->type];
    }

    public function playoff()
    {
      $playoff = array();
      $stages = array('16r', 'qt', 'sf', '3rd', 'f');

      foreach ($stages as $st)
      {
        $games = Game::where('tournament_id', $this->id)->where('stage', $st)->get();
        if (count($games) != 0)
          $playoff[$st] = $games;
      }
      return $playoff;
    }

    public function teams()
    {
      $teams = array();
      foreach ($this->groups as $group)
      {
        foreach ($group->teams as $team)
        {
          $teams[] = $team;
        }
      }
      return $teams;
    }

    // deprecated TODO remove dL korzysta?
    public function teamsForPlayoff()
    {
      $groups = array();
      foreach ($this->groups as $group)
      {
        array_push($groups, $group->id);
      }
      $array = Team::whereIn('group_id', $groups)->pluck('name', 'id');
      $array->prepend('no selected', 'no selected');
      return $array;
    }

    public function getSeed($seed)
    {
      $name = explode(' #', $seed)[0];

      $stages = array('16r', 'qt', 'sf', '3rd', 'f');

      // Jeśli seed wskazuje na rundę
      if (in_array($name, $stages) || in_array(str_replace('l ', '', $name), $stages))
      {
        // sprawdź czy seed to przegrany
        $winner = strpos($name, 'l ') === false;

        // ustaw nazwę rundy
        if (!$winner)
          $name = str_replace('l ', '', $name);
        $pos = (int)explode(' #', $seed)[1];

        // pobierz mecz
        $game = $this->games()->where('stage', $name)->get()[$pos];
        if ($game->isOver())
        {
          // zwróć drużynę
          return $winner ? $game->winner() : $game->loser();
        }
      }
      // Jeśli seed wskazuje na grupę
      else
      {
        // pobierz grupę
        $group = $this->groups()->where('name', $name)->first();
        if ($group != null && $group->isOver())
        {
          // Jeżeli grupa zakończyła rozgrywki, zwróć team z danej pozycji
          $pos = (int)explode(' #', $seed)[1];
          return $group->ranking()[$pos]->team;
        }
      }

      // Jeżeli żadna reguła nie pasuje, zwróć ten sam seed
      return "<i>".strToUpper($seed)."</i>";
    }

    public function getRoundSeeds($stage)
    {
      $seeds = [];
      $stages = array('16r' => 8, 'qt' => 4, 'sf' => 2, 'f' => 1, 'l sf' => 2, '3rd' => 1 );

      // znajdź wcześniejszą rundę
      $prev = null;
      foreach ($stages as $st => $v)
      {
        if ($st == $stage)
        {
            // Jeśli to pierwsza runda, zwróć seedy z grup
            if ($prev == null || $stages[$prev] == $this->seeds)
            {
              return $this->getGroupsSeeds();
            }
            break;
        }
        $prev = $st;
      }
      for ($i=0; $i<$stages[$prev]; $i++)
      {
        $name = $prev." #".($i);
        $prev_seed = $this->getSeed($name);
        $seeds[$name] = $name.($prev_seed instanceof Team ? " (".$prev_seed->name.")" : "" );
      }
      return $seeds;
    }

    private function getGroupsSeeds()
    {
      $seeds = [];
      foreach ($this->groups as $group)
      {
        for ($i=0; $i<count($group->teams); $i++)
        {
          $name = $group->name." #".($i);
          $prev_seed = $this->getSeed($name);
          $seeds[$name] = $name.($prev_seed instanceof Team ? " (".$prev_seed->name.")" : "" );
        }
      }
      return $seeds;
    }
}
