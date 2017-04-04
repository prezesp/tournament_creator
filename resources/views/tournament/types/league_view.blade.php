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
    </div>

  @include('tournament.scripts.update-game-js', ['settings' => (object) ['view' => 'league_view', 'section' => 'mod-content', 'only_score' => true]])
  @endsection

  @yield('mod-content')

@endcomponent
