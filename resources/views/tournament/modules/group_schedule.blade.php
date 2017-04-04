<div class="row">
  <div class="col-sm-12">
    <h5>
      @if (!empty($title))
        {{ $title }}
      @endif
    </h5>
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-hover">
        @foreach ($group->games as $game)
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
            @if ($group->tournament->user == Auth::user() || $group->tournament->moderators->contains(Auth::user()))
              <td class="match-edit"><a data-toggle="modal" data-target="#modal_{{$game->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            @endif
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
@foreach ($group->games as $game)
  @include('tournament/modules/game_modal', [ 'game' => $game, 'only_score' => ($group->tournament->type != 'DL'), 'teams' =>$group->tournament->teamsForPlayoff() ])
@endforeach
