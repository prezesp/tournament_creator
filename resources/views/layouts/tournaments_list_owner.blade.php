<table class="table table-hover table-responsive table-striped">
  <thead>
    <tr>
      <th>Name</th><th>Sport</th><th>Type</th><th>Date</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($tournaments as $tournament)
    <tr class="clickable-row" data-toggle="collapse" data-target="#accordion_{{ $tournament->id }}">
      <td class="col-sm-6">
        <strong>{{ $tournament->name }}</strong>
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
    <tr>
      <td colspan="4" class="list_details">
        <div id="accordion_{{ $tournament->id }}" class="collapse">
          <div></div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-8">
                <em>{{ $tournament->description }}</em>
              </div>
              <div class="col-sm-2">
                {{ count($tournament->teams()) }} <i class="fa fa-users"></i>
              </div>
              <div class="col-sm-2">
                {{ Form::open([ 'method'  => 'delete', 'route' => [ 'tournament.destroy', $tournament->id ] ]) }}
                {{ Form::hidden('id', $tournament->id) }}
                  <a href="{{ route('tournament.show', $tournament->id) }}" class="btn btn-xs btn-primary">Go</a>
                  <a href="{{ route('tournament.edit', $tournament->id) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                  <a class="btn btn-xs btn-info data-delete"><i class="fa fa-trash"></i></a>
                {{ Form::close() }}
              </div>
            </div>
          </div>
        </div>

      </td>
    </tr>      
    @endforeach
  </tbody>
</table>
<div class="text-center">
  {!! $tournaments->render() !!}
</div>