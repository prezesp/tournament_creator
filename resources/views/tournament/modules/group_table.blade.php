<div class="panel panel-default">
  <div class="panel-heading" style="background-color: #f5f5f5;">
    @if (!empty($title))
      {{ $title }}
    @endif
  </div>
  <table class="table table-condensed table-hover">
    <tr>
      <th>Team</th>
      <th>G</ht>
      <th>Pts</th>
      <th>+/-</th>
    </tr>
    @foreach ($group->ranking() as $rank)
      <tr>
        <td>{{ $rank->team->name }}</td>
        <td>{{ $rank->game_count }}</td>
        <td>{{ $rank->points }}</td>
        <td>{{ $rank->balance_plus }} - {{ $rank->balance_minus }}</td>
      </tr>
    @endforeach
  </table>
</div>
