@foreach ($tournament->playoff() as $stage => $games)
<div class="panel panel-default">
  <div class="panel-heading dupa_2">{{ Lang::get('tournament.'.$stage) }}</div>
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-hover">
      @foreach ($games as $game)
      <tr>
        <td class="match-date col-md-1">{{ empty($game->game_time) ? '00:00' : $game->game_time }}</td>
        <td class="col-md-4 text-center">
          <?php
            $home = !empty($game->home) ? $game->home : $tournament->getSeed($game->home_seed);
           ?>
          @if ($game->winner() == $home)
            <strong>{!! $home instanceof App\Team ? $home->name : $home !!}</strong>
          @else
            {!! $home instanceof App\Team ? $home->name : $home !!}
          @endif
        </td>
        <td class="col-md-1 text-right">{{ $game->home_score }}</td>
        <td class="text-center">:</td>
        <td class="col-md-1">{{ $game->away_score }}</td>
        <td class="col-md-4 text-center">
          <?php
            $away = !empty($game->away) ? $game->away : $tournament->getSeed($game->away_seed);
           ?>
          @if ($game->winner() == $away)
            <strong>{!! $away instanceof App\Team ? $away->name : $away !!}</strong>
          @else
            {!! $away instanceof App\Team ? $away->name : $away !!}
          @endif
        </td>
        @if ($tournament->user == Auth::user() || $tournament->moderators->contains(Auth::user()))
          <td class="match-edit"><a data-toggle="modal" data-target="#modal_{{$game->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
        @endif
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endforeach

<?php
  // pierwsza faza dla typu 'P' jest nieedytowalna
  $only_score = $tournament->type == 'P';
 ?>
@foreach ($tournament->playoff() as $stage => $games)
  @foreach ($games as $game)
    @include('tournament/modules/po_game_modal', [ 'game' => $game, 'teams' => $tournament->getRoundSeeds($stage), 'only_score' => $only_score])
  @endforeach
  <?php
    $only_score = false;
   ?>
@endforeach
