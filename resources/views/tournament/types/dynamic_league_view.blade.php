@component('tournament.types.view', ['tournament' => $tournament, 'comments' => empty($comments) ? [] : $comments])
  @slot('nav')
    <li role="presentation"
      {{ !isset($_GET['comments']) ? 'class=active' : ''}}>
      <a href="?">{{ trans('tournament.results') }}</a>
    </li>
  @endslot

  @section('mod-content')
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-12">
          @component('tournament/modules/group_table', ['group' => $tournament->groups[0], 'title' => trans('tournament.table')])
          @endcomponent
        </div>
      </div>
    </div>
    <div class="panel-heading"></div>
    <div class="panel-heading">{{ trans('tournament.schedule') }}</div>
    <div class="panel-body">
      @foreach ($tournament->groups as $group)
        @component('tournament/modules/group_schedule', ['group' => $group])
        @endcomponent
      @endforeach

      <div class="row">
        <div class="col-sm-12">
          @if ($group->tournament->user == Auth::user() || $group->tournament->moderators->contains(Auth::user()))
            {{ Form::open(array('method' => 'PUT', 'route' => ['game.store'], 'class' => 'form-horizontal add-team')) }}
              <div class="progress" style="display:none;">
                <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%">
                </div>
              </div>
              <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> New game</button>
            {{ Form::close() }}
          @endif
        </div>
      </div>
    </div>

    <?php $settings = (object) ['view' => 'dynamic_league_view', 'section' => 'mod-content'] ?>
    @include('tournament.scripts.create-game-js', ['settings' => $settings])
    @include('tournament.scripts.destroy-game-js', ['settings' => $settings])
    @include('tournament.scripts.update-game-js', ['settings' => $settings])
  @stop
  @yield('mod-content')


@endcomponent
