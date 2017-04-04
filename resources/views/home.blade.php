@extends('layouts.app')

@section('content')

@component('layouts.breadcrumb', ['title' => 'dashboard'])
  <li class="active">Dashboard</li>
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
                <div class="panel-heading">My tournaments</div>

                <div class="panel-body">
                  @if (Auth::user()->tournaments->isEmpty())
                    <em> No tournaments </em>
                  @endif
                  @foreach (Auth::user()->tournaments as $tournament)
                    <div class="list-group">
                      <a href="{{ URL::route('tournament.show', $tournament->id) }}" class="list-group-item">
                        <div class="row">
                          <div class="col-sm-6">
                            <h4 class="list-group-item-heading">
                              {{ $tournament->name }}
                            </h4>
                          </div>
                          <!--
                          <div class="col-sm-2">
                            <i class="fa fa-futbol-o"></i>
                          </div>
                          -->
                          <div class="col-sm-3 col-sm-offset-1">
                            <p class="list-group-item-text text-justify">{{ $tournament->type_longname() }}</p>
                          </div>
                          <div class="col-sm-2">
                            <p class="list-group-item-text text-justify">{{ $tournament->date }}</p>
                          </div>
                        </div>
                      </a>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
