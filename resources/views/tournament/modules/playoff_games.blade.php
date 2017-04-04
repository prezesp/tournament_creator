@foreach ($tournament->playoff() as $stage => $games)
<div class="panel panel-default">
  <div class="panel-heading dupa_2">{{ Lang::get('tournament.'.$stage) }}</div>
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-hover">
      @foreach ($games as $game)
      <tr>
        <td class="match-date col-md-1">{{ empty($game->game_time) ? '00:00' : $game->game_time }}</td>
        <td class="col-md-4 text-center">
          @if (!empty($game->home) && $game->winner() == $game->home)
            <strong>{{ $game->home->name }}</strong>
          @else
            {!! empty($game->home) ? "<i>no selected</i>" : $game->home->name !!}
          @endif
        </td>
        <td class="col-md-1 text-right">{{ $game->home_score }}</td>
        <td class="text-center">:</td>
        <td class="col-md-1">{{ $game->away_score }}</td>
        <td class="col-md-4 text-center">
          @if (!empty($game->away) && $game->winner() == $game->away)
            <strong>{{ $game->away->name }}</strong>
          @else
            {!! empty($game->away) ? "<i>no selected</i>" : $game->away->name !!}
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

@foreach ($tournament->playoff() as $stage => $games)
  @foreach ($games as $game)
    @include('tournament/modules/game_modal', [ 'game' => $game, 'teams' => $tournament->teamsForPlayoff() ])
  @endforeach
@endforeach
