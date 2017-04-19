<table class="table table-hover table-responsive table-striped">
  <thead>
    <tr>
      <th>Name</th><th></th><th>Sport</th><th>Type</th><th>Date</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($tournaments as $tournament)
    <tr class="clickable-row" data-href="{{ route('tournament.show', $tournament->id) }}">
      <td class="col-sm-5">
        <strong>{{ $tournament->name }}</strong>
      </td>
      <td class="col-sm-1 text-center">
        {{ count($tournament->teams()) }} <i class="fa fa-users"></i>
      </td>
      <td class="col-sm-2">
        {{ trans('sports.'.$tournament->sport) }}
      </td>
      <td class="col-sm-2">
        {{ $tournament->type_longname() }}
      </td>
      <td class="col-sm-2">
        {{ $tournament->date }}
      </td>
    </tr>  
    @endforeach
  </tbody>
</table>
<div class="text-center">
  {!! $tournaments->render() !!}
</div>

<script>
$(function() {
  $('tr.clickable-row').on('click', function() {
    window.location = $(this).data('href');
  });
})
</script>