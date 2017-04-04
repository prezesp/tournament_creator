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

                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{ trans('tournament.name') }}</label>
                    <div class="col-sm-8">
                      {{ Form::text('name', $tournament->name, array('class' => 'form-control', 'placeholder' => trans('tournament.name'), 'required' )) }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{ trans('tournament.description') }}</label>
                    <div class="col-sm-8">
                      {{ Form::textarea('description', $tournament->description, array('class' => 'form-control', 'placeholder' => trans('tournament.description'), 'rows' => 3, 'required')) }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{ trans('tournament.webpage') }}</label>
                    <div class="col-sm-8">
                      {{ Form::text('webpage', $tournament->www, array('class' => 'form-control', 'placeholder' => 'www.your-site.com')) }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{ trans('tournament.date') }}</label>
                    <div class="col-sm-8">
                      <div class='input-group date'>
                        <input type='text' name="date" class="form-control" value="{{ $tournament->date }}" pattern="^[0-9]{4,}\-[0-9]{2}\-[0-9]{2}$" required/>
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

});
</script>
@endsection
