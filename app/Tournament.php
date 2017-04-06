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

    public function teamsForPlayoff()
    {
      // powinny byc posortowane wg bilansu
      $teams = array();
      $groups = array();
      foreach ($this->groups as $group)
      {
        array_push($groups, $group->id);
        foreach ($group->teams as $team)
        {
          array_push($teams, $team->pluck('name', 'id'));
        }
      }
      $array = Team::whereIn('group_id', $groups)->pluck('name', 'id');
      $array->prepend('no selected', 'no selected');
      return $array;
    }
}
