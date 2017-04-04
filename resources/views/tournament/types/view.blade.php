<ul class="nav nav-tabs tournament-nav">
  {{ $nav }}
  <li role="presentation"
  {{ isset($_GET['comments']) ? 'class=active' : ''}}>
    <a href="?comments">{{ trans('tournament.comments') }}
      @if (count($tournament->comments) > 0)
        <span class="badge">{{ count($tournament->comments) }}</span>
      @endif
    </a>
  </li>
</ul>
<div class="panel panel-default tournament-content {{ (!isset($_GET['playoff']) && !isset($_GET['comments']) ? 'tournament-content-first' : '') }}">
  @if (isset($_GET['comments']))
    @include('tournament/modules/comments', ['tournament' => $tournament, 'comments' => $comments])
  @else
    {{ $slot }}
  @endif
</div>
