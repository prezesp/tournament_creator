@extends('layouts.app')

@section('content')
@component('layouts.breadcrumb', ['title' => strToUpper(trans('tournament.tournament'))])
  <li><a href="{{ route('tournament.index') }}">{{ trans('tournament.tournaments') }}</a></li>
  <li class="active">{{ $tournament->name }}</li>
@endcomponent

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if( Session::has('message') )
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  {{ Session::get('message') }}
              </div>
            @endif
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-7">
                    {{ trans('tournament.tournament') }}
                  </div>
                  <div class="col-xs-5 pull-right">
                    <div class="pull-right">
                      <div class="dropdown">
                        {{ Form::open([ 'method'  => 'delete', 'route' => [ 'tournament.destroy', $tournament->id ] ]) }}
                        {{ Form::hidden('id', $tournament->id) }}
                        <a class="dropdown-toggle tournament-dropdown-options" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="fa fa-cog"></i> {{ trans('tournament.tools') }} <span class="caret"></span></a>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                          @if ($tournament->user == Auth::user() || $tournament->moderators->contains(Auth::user()))
                            <li><a href="{{ route('tournament.edit', $tournament->id) }}">{{ trans('tournament.edit') }}</a></li>
                          @endif
                          <li><a data-toggle="modal" data-target="#export_modal">{{ trans('tournament.export') }}</a></li>
                          @if ($tournament->user == Auth::user())
                            <li role="separator" class="divider"></li>
                            <li><a href="#" class="data-delete">{{ trans('tournament.delete') }}</a></li>
                          @endif
                        </ul>
                      </div>
                      {{ Form::close() }}
                    </div>
                  </div>
                </div>
              </div>


              <div class="panel-body">
                <h3 class="tournament-title">{{ $tournament->name }}</h3>
                <p>
                  {{ $tournament->description }}
                </p>
                <hr/>
                <div class="row">
                  <div class="col-sm-6">
                    <p><i class="fa fa-calendar" aria-hidden="true"></i> {{ $tournament->date }}</p>
                  </div>
                  @if (!empty($tournament->www))
                    <div class="col-sm-6">
                      <p><i class="fa fa-info-circle" aria-hidden="true"></i> <a href="http://{{ $tournament->www }}">{{ $tournament->www }}</a></p>
                    </div>
                  @endif
                </div>
                @if (!empty($tournament->sport))
                <div class="row">
                  <div class="col-sm-6">
                    <i class="fa fa-trophy" aria-hidden="true"></i> {{ trans('sports.'.$tournament->sport) }}
                  </div>
                </div>
                @endif
              </div>
            </div>

            @if ($tournament->type == 'DL')
              @include('tournament/types/dynamic_league_view', ['tournament' => $tournament])
            @elseif ($tournament->type == 'L')
              @include('tournament/types/league_view', ['tournament' => $tournament])
            @elseif ($tournament->type == 'P')
              @include('tournament/types/playoff_view', ['tournament' => $tournament])
            @elseif ($tournament->type == 'GP')
              @include('tournament/types/groups_and_playoff_view', ['tournament' => $tournament])
            @endif
        </div>
    </div>
</div>
<script>
$(function () {
  $('.data-delete').on('click', function (e) {
    if (!confirm('Are you sure you want to delete?')) return;
    e.preventDefault();
    $(this).parentsUntil("form").parent().submit();
  });
});
</script>

@include('tournament/modules/export_modal')
@endsection
