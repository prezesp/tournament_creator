@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      &nbsp;
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          {{ Form::open(array('method'=> 'PUT', 'route' => ['tournament.update', $tournament->id], 'class' => 'form-horizontal', 'data-toggle' => 'validator')) }}
            <div class="panel panel-default">
              <div class="panel-heading">Edit Tournament</div>

              <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label">{{ trans('tournament.name') }}</label>
                  <div class="col-sm-8">
                    {{ Form::text('name', $tournament->name, array('class' => 'form-control', 'placeholder' => trans('tournament.name'), 'required')) }}
                  </div>
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label">{{ trans('tournament.description') }}</label>
                  <div class="col-sm-8">
                    {{ Form::textarea('description', $tournament->description, array('class' => 'form-control', 'placeholder' => trans('tournament.description'), 'rows' => 3, 'required')) }}
                  </div>
                </div>
                <div class="form-group{{ $errors->has('sport') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label">Sport</label>
                  <div class="col-sm-8">
                    <div class='input-group'>
                      <input name='sport_name' type='text' class="form-control btn-search" autocomplete="off"  value="{{ !empty($tournament->sport) ? trans('sports.'.$tournament->sport) : '' }}" required/>
                      <span class="input-group-addon btn-inside">
                        <i class="fa fa-search"></i>
                      </span>
                    </div>
                    <input name='sport' type='hidden' class="form-control" value="{{ $tournament->sport }}"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">{{ trans('tournament.webpage') }}</label>
                  <div class="col-sm-8">
                    {{ Form::text('webpage', $tournament->www, array('class' => 'form-control', 'placeholder' => 'www.your-site.com')) }}
                  </div>
                </div>
                <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label">{{ trans('tournament.date') }}</label>
                  <div class="col-sm-8">
                    <div class='input-group date'>
                      <input type='text' name="date" class="form-control" value="{{ $tournament->date }}" pattern="^[0-9]{4,}\-[0-9]{2}\-[0-9]{2}$" required />
                      <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    {{ Form::checkbox('is_private', 1, $tournament->is_private) }} {{ trans('tournament.private_event') }} <span data-toggle="tooltip" data-placement="top" title="Only users with shared link can see it"><i class="fa fa-question-circle"></i></span>
                  </div>
                </div>
                @if ($tournament->type != 'P')
                  <div class="form-group create-form-points">
                    <label class="col-sm-3 control-label">{{ trans('tournament.points') }}</label>
                    <div class="col-sm-8">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-xs-4">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon hidden-xs">Win</span>
                                <span class="input-group-addon visible-xs-table-cell">W</span>
                                {{ Form::text('win_pts', $tournament->win_pts, array('class' => 'form-control', 'pattern' => '^[0-9]{1,}(\.[0-9]{1,2})?$', 'required')) }}
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-4">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon hidden-xs">Draw</span>
                                <span class="input-group-addon visible-xs-table-cell">D</span>
                                {{ Form::text('draw_pts', $tournament->draw_pts, array('class' => 'form-control', 'pattern' => '^[0-9]{1,}(\.[0-9]{1,2})?$', 'required')) }}
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-4">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon hidden-xs">Lose</span>
                                <span class="input-group-addon visible-xs-table-cell">L</span>
                                {{ Form::text('loss_pts', $tournament->loss_pts, array('class' => 'form-control', 'pattern' => '^[0-9]{1,}(\.[0-9]{1,2})?$', 'required')) }}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            </div>

            @if ($tournament->user == Auth::user())
              <div class="panel panel-default">
                <div class="panel-heading">Moderators</div>
                <div class="panel-body">

                  <div class="mod-plugin-container">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Search</label>
                      <div class="col-sm-8">
                        <div class='input-group'>
                          <input type='text' class="form-control" autocomplete="off"/>
                          <div class="input-group-btn">
                            <button class="btn btn-default btn-inside" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                          </div>
                        </div>
                        <div class='input-group'>
                          <ul class="dropdown-menu" role="menu">
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-2">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-user-plus" aria-hidden="true"></i> Add moderator</button>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Selected users</label>
                      <div class="col-sm-8">
                        <ul class="list-group">

                        </ul>
                      </div>
                    </div>
                    <input type='hidden' name='moderators' class="form-control" autocomplete="off" value="{{ $tournament->moderators->pluck('id', 'name') }}"/>
                  </div>
                </div>
              </div>
            @endif

            <div class="panel panel-default">
              <div class="panel-heading">Summary</div>
              <div class="panel-body">

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    <a href="{{ route('tournament.show', $tournament->id) }}" class="btn btn-default">Cancel</a>
                    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                  </div>
                </div>

              </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<!--script type="text/javascript" src="{{ asset('js/YConsole-compiled.js') }}"></script-->
<!--script type="text/javascript" >YConsole.show();</script-->

<script>
$( document ).ready(function() {
  $('.mod-plugin-container').search("{{ url('users/search', '') }}", $('input[name=moderators]'));

  var datepicker = $('input[name="date"]').datepicker( { 'format': 'yyyy-mm-dd', 'weekStart': 1 })
  .on('changeDate', function(ev){
    datepicker.hide();
    $(this).trigger('input')
  }).data('datepicker');

  // typeahead
  var input = $("input[name=sport_name]");
  $.get("{{ route('sport.index') }}", function(data) {
    input.typeahead({
      source: data,
      autoSelect: true,
      afterSelect: function(item) {
        if (item != undefined) {
          $("input[name=sport]").val(item.id);
        }
      }
    });
  },'json');

  input.change(function() {
    var current = input.typeahead("getActive");
    if (current) {
      // Some item from your model is active!
      if (current.name == input.val()) {
        // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
      } else {
        input.val('');
        // This means it is only a partial match, you can either add a new item
        // or take the active if you don't want new items
      }
    } else {
      // Nothing is active so it is a new value (or maybe empty value)
    }
  });
});
</script>
@endsection
