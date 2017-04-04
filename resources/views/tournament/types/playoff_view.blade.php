@component('tournament.types.view', ['tournament' => $tournament, 'comments' => empty($comments) ? [] : $comments])
  @slot('nav')
    <li role="presentation"
      {{ !isset($_GET['comments']) ? 'class=active' : ''}}>
      <a href="?">{{ trans('tournament.results') }}</a>
    </li>
  @endslot

  @section('mod-playoff')
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-12">
          @include('tournament.modules.playoff_games', ['tournament' => $tournament])
        </div>
      </div>
    </div>
    @include('tournament.scripts.update-game-js', ['settings' => (object) ['view' => 'playoff_view', 'section' => 'mod-playoff']])
  @endsection

  @yield('mod-playoff')

@endcomponent
