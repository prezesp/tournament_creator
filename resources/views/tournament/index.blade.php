@extends('layouts.app')

@section('content')
@component('layouts.breadcrumb', ['title' => trans('tournament.tournaments')])
  <li class="active">{{ trans('tournament.tournaments') }}</li>
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
                <div class="panel-heading">{{ trans('tournament.tournaments') }}</div>

                <div class="panel-body">
                    @if ($tournaments->isEmpty())
                    <em> No tournaments </em>
                    @endif
                    @foreach ($tournaments as $tournament)
                      <div class="list-group">
                        <a href="{{ URL::route('tournament.show', $tournament->id) }}" class="list-group-item">
                          <div class="row">
                            <div class="col-sm-7">
                              <h4 class="list-group-item-heading">
                                {{ $tournament->name }}
                              </h4>
                              <p class="list-group-item-text text-justify">{{ $tournament->description }}</p>
                            </div>
                            <!--
                            <div class="col-sm-2">
                              <i class="fa fa-futbol-o"></i>
                            </div>
                            -->
                            <div class="col-sm-2 col-sm-offset-1">
                              <h4 class="list-group-item-heading">&nbsp;</h4>
                              <p class="list-group-item-text text-justify">{{ $tournament->type_longname() }}</p>
                            </div>
                            <div class="col-sm-2">
                              <h4 class="list-group-item-heading">&nbsp;</h4>
                              <p class="list-group-item-text text-justify">{{ $tournament->date }}</p>
                            </div>
                      </div>
                        </a>
                      </div>
                    @endforeach

                  {!! $tournaments->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<br/>
<!--&nbsp;&nbsp;&nbsp;<i class="fa fa-trophy" style="font-size:260px;"></i>-->
@endsection
