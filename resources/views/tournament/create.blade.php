@extends('layouts.app')

@section('content')
@component('layouts.breadcrumb', ['title' => trans('tournament.create') ])
  <li class="active">{{ trans('tournament.create_tournament') }}</li>
@endcomponent
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          {{ Form::open(array('route' => 'tournament.store', 'class' => 'form-horizontal', 'data-toggle' => 'validator')) }}
            <div class="panel panel-default">
              <div class="panel-heading">{{ trans('tournament.create_tournament') }}</div>

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
                    {{ Form::text('name', '', array('class' => 'form-control', 'placeholder' => trans('tournament.name'), 'required')) }}
                  </div>
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label">{{ trans('tournament.description') }}</label>
                  <div class="col-sm-8">
                    {{ Form::textarea('description', old('description'), array('class' => 'form-control', 'placeholder' => trans('tournament.description'), 'rows' => 3, 'required')) }}
                  </div>
                </div>
                <div class="form-group{{ $errors->has('sport') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label">Sport</label>
                  <div class="col-sm-8">
                    <div class='input-group'>
                      <input name='sport_name' type='text' class="form-control btn-search" autocomplete="off" required/>
                      <span class="input-group-addon btn-inside">
                        <i class="fa fa-search"></i>
                      </span>

                    </div>
                    <input name='sport' type='hidden' class="form-control" value="{{ old('sport') }}"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">{{ trans('tournament.webpage') }}</label>
                  <div class="col-sm-8">
                    {{ Form::text('webpage', '', array('class' => 'form-control', 'placeholder' => 'www.your-site.com')) }}
                  </div>
                </div>
                <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                  <label class="col-sm-3 control-label">{{ trans('tournament.date') }}</label>
                  <div class="col-sm-8">
                    <div class='input-group date'>
                      <input type='text' name="date" class="form-control" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" pattern="^[0-9]{4,}-[0-9]{2}-[0-9]{2}$" required/>
                      <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    {{ Form::checkbox('is_private') }} {{ trans('tournament.private_event') }} <span data-toggle="tooltip" data-placement="top" title="Only users with shared link can see it"><i class="fa fa-question-circle"></i></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">{{ trans('tournament.type') }}</label>
                  <div class="col-sm-8">
                    {{ Form::select('type', array('GP' => trans('tournament.group_and_playoff'), 'P' => 'Playoff', 'L' => trans('tournament.league'), 'DL' => trans('tournament.dynamic_league')), 'GP', array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">{{ trans('tournament.seeds') }}</label>
                  <div class="col-sm-8">
                    {{ Form::select('seeds', array('2' => trans('tournament.2seed'), '4' => trans('tournament.4seed'), '8' => trans('tournament.8seed'), '16' => trans('tournament.16seed')), '2', array('class' => 'form-control')) }}
                  </div>
                </div>
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
                              {{ Form::text('win_pts', '3.0', array('class' => 'form-control', 'pattern' => '^[0-9]{1,}(\.[0-9]{1,2})?$', 'required')) }}
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-4">
                          <div class="form-group">
                            <div class="input-group">
                              <span class="input-group-addon hidden-xs">Draw</span>
                              <span class="input-group-addon visible-xs-table-cell">D</span>
                              {{ Form::text('draw_pts', '1.0', array('class' => 'form-control', 'pattern' => '^[0-9]{1,}(\.[0-9]{1,2})?$', 'required')) }}
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-4">
                          <div class="form-group">
                            <div class="input-group">
                              <span class="input-group-addon hidden-xs">Lose</span>
                              <span class="input-group-addon visible-xs-table-cell">L</span>
                              {{ Form::text('loss_pts', '0.0', array('class' => 'form-control', 'pattern' => '^[0-9]{1,}(\.[0-9]{1,2})?$', 'required')) }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    {{ Form::checkbox('name', 'value') }} Match & rematch
                  </div>
                </div-->
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-8">
                    {{ trans('tournament.teams') }}
                  </div>
                  <div class="col-xs-4">
                    <div class="pull-right">
                    <button type="button" class="close" aria-label="Close" data-toggle="tooltip" data-placement="top" title="Be smart! Use ENTER to create new line for team.">Hint <i class="fa fa-question-circle"></i></button>
                  </div>
                  </div>
                </div>
              </div>
              <div class="panel-body">

                <div class="mod-plugin-container">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{ trans('tournament.groups_count') }}</label>
                    <div class="col-sm-8">
                      {{ Form::number('group_counter','1', array('class' => 'form-control', 'min' => 1, 'max' => 8)) }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{ trans('tournament.teams') }} <span class='team_counter'></span></label>
                    <div class="col-sm-8 item-container">
                    </div>
                  </div>
                  <div class="form-group alerts">
                    <div class="col-sm-offset-3 col-sm-8">
                      <div class="alert alert-danger" style="display:none">
                        <strong>{{ trans('common.warning') }}!</strong> {{ trans('tournament.e_twice_same_team_warning') }}
                      </div>
                      <div class="alert alert-danger alert-dismissable" style="display:none">
                        <button type="button" class="close" aria-hidden="true" onclick="$(this).parent().hide()">&times;</button>
                        <strong>{{ trans('common.warning') }}!</strong> {{ trans('tournament.e_empty_names_warning') }}
                      </div>
                      <div class="alert alert-danger alert-dismissable" style="display:none">
                        <button type="button" class="close" aria-hidden="true" onclick="$(this).parent().hide()">&times;</button>
                        <strong>{{ trans('common.warning') }}!</strong> {{ trans('tournament.e_teams_equals_seeds') }}
                      </div>
                      @if ($errors->has('teams.*'))
                        <div class="alert alert-danger alert-dismissable" style="display:none">
                          <button type="button" class="close" aria-hidden="true" onclick="$(this).parent().hide()">&times;</button>
                          <strong>{{ trans('common.warning') }}!</strong><br/>
                          @foreach ($errors->get('teams.*') as $message)
                            {{ $message[0] }}<br/>
                          @endforeach
                        </div>
                        @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                      <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('tournament.add_team') }}</button>
                      <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-random" aria-hidden="true"></i> {{ trans('tournament.shuffle') }}</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">{{ trans('tournament.summary') }}</div>
              <div class="panel-body">

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    {{ Form::submit(trans('tournament.create'), array('class' => 'btn btn-primary')) }}
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
var type = 'GP';

// BEGIN ZMIANA TYPU TURNIEJU
var onTypeChange = function(type) {
  var to_hide = new Array();
  var to_show = new Array();

  if (type == 'DL' || type == 'L') {
    to_hide.push($('select[name="seeds"]').parentsUntil(".form-group").parent());
    to_show.push($('input[name="win_pts"]').parentsUntil(".container-fluid").parentsUntil(".form-group").parent());
  }
  if (type == 'GP' || type == 'DL' || type == 'L') {
    $('input[name="win_pts"]').attr('required', true);
    $('input[name="draw_pts"]').attr('required', true);
    $('input[name="lose_pts"]').attr('required', true);
  }
  if (type == 'P') {
    $('input[name="win_pts"]').removeAttr('required');
    $('input[name="draw_pts"]').removeAttr('required');
    $('input[name="loss_pts"]').removeAttr('required');
  }
  if (type == 'P') {
    to_show.push($('select[name="seeds"]').parentsUntil(".form-group").parent());
    to_hide.push($('input[name="win_pts"]').parentsUntil(".container-fluid").parentsUntil(".form-group").parent());
  }
  if (type == 'GP') {
    to_show.push($('select[name="seeds"]').parentsUntil(".form-group").parent());
    to_show.push($('input[name="win_pts"]').parentsUntil(".container-fluid").parentsUntil(".form-group").parent());
  }

  to_hide.forEach(function (div) {
    $(div).animate({
      'opacity': 0
    }, {
      queue: false,
      duration: 600,
      complete : function () {
        $(this).css('display', 'none');
      }
    });
  });
  to_show.forEach(function (div) {
    $(div).css('display', 'block');
    $(div).animate({
      'opacity': 1
    }, {
      queue: false,
      duration: 600,
    });
  });
};
// END


$( document ).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();

  var datepicker = $('input[name="date"]').datepicker( { 'format': 'yyyy-mm-dd', 'weekStart': 1 })
  .on('changeDate', function(ev){
    datepicker.hide();
    $(this).trigger('input')
  }).data('datepicker');

  //var plugin = $('.mod-plugin-container').teams_plugin(undefined, { 'debug' : false });
  var plugin = $('.mod-plugin-container').teams_plugin();

  @if (!empty(old('teams')))
    var values = new Array();
    @foreach (old('teams') as $team)
      values.push('{{ is_null($team) ? "" : $team }}');
    @endforeach
    plugin.teams_plugin('initByValues', {'items': values });
  @endif

  $('select[name="type"]').change(function() {
    type = $(this).val();
    onTypeChange(type);
    plugin.teams_plugin('setType', { 'type' : type });
  });


  // typeahead
  var input = $("input[name=sport_name]");
  $.get("{{ route('sport.index') }}", function(data) {
    var sport = $("input[name=sport]").val();
    for (var i=0; sport.length>0 && i<data.length; i++) {
      if (sport == data[i].id) {
        input.val(data[i].name);
        break;
      }
    }

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
      if (current.name != input.val())
      {
        input.val('');
      }
    }
  });

  $('#app form').on('submit', function(e) {
    var valid = plugin.teams_plugin('validate', {
      'custom_validator' : function(v_type, itemCount) {
        var alert = plugin.find('.alert-danger').eq(2);
        if (v_type == 'P') {
          if (itemCount != parseInt($('#app form select[name=seeds]').val())) {
            alert.css('display', 'block');
            return false;
          }
        }
        alert.css('display', 'none');
        return true;
      }});
    if (!valid) {
      e.preventDefault();
    }
  })
});


</script>

@endsection
