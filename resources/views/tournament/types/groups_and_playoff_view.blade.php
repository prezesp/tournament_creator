@component('tournament.types.view', ['tournament' => $tournament, 'comments' => empty($comments) ? [] : $comments])
  @slot('nav')
    <li role="presentation"
      {{ !isset($_GET['playoff']) && !isset($_GET['comments']) ? 'class=active' : ''}}>
      <a href="?">{{ trans('tournament.group_stage') }}</a>
    </li>
    <li role="presentation"
      {{ isset($_GET['playoff']) ? 'class=active' : ''}}>
      <a href="?playoff">Playoff</a>
    </li>
  @endslot

  @section('mod-groups')
    <div class="panel-body">
      <div class="row">
        @foreach ($tournament->groups as $group)
          <div class="col-sm-6">
            @component('tournament/modules/group_table', ['group' => $group, 'title' => trans('tournament.group').' '.$group->name ])
            @endcomponent
          </div>
        @endforeach
      </div>
    </div>
    <div class="panel-heading"></div>
    <div class="panel-heading">{{ trans('tournament.schedule') }}</div>
    <div class="panel-body">
      @foreach ($tournament->groups as $group)
        @component('tournament/modules/group_schedule', ['group' => $group, 'title' => trans('tournament.group').' '.$group->name])
        @endcomponent
      @endforeach
    </div>
    @include('tournament.scripts.update-game-js', ['settings' => (object) ['view' => 'groups_and_playoff_view', 'section' => 'mod-groups', 'only_score' => true]])
  @endsection

  @section('mod-playoff')
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-12">
          @include('tournament.modules.playoff_games', ['tournament' => $tournament])
        </div>
      </div>
    </div>
    @include('tournament.scripts.update-game-js', ['settings' => (object) ['view' => 'groups_and_playoff_view', 'section' => 'mod-playoff']])
  @endsection

  @if (isset($_GET['playoff']))
    @yield('mod-playoff')
  @else
    @yield('mod-groups')
  @endif
@endcomponent
