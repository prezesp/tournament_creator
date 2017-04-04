<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
  public $timestamps = false;

  /**
   * attributes
   */
  protected $fillable = [
    'name'
  ];

  public function group()
  {
    return $this->belongsTo('App\Group');
  }
}
