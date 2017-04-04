@extends('layouts.app')

@section('content')
<div class="welcome">
  <div class="welcome-layer">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="jumbotron">
            <h1 class="text-center"><i class="fa fa-trophy" aria-hidden="true"></i> {{ trans('main.welcome_title') }}</h1>
            <p class="text-center">{{ trans('main.welcome_message') }}</p>
            <p class="text-center"><a class="btn btn-primary" href="#" role="button">{{ trans('main.learn_more') }}</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    &nbsp;
  </div>
  <div class="row">
    &nbsp;
  </div>
  <div class="row">
    &nbsp;
  </div>
  <div class="row">
    <div class="col-sm-2 col-sm-offset-2 col-xs-6 text-center">
      <a class="thumbnail">
        <h2><i class="fa fa-trophy" aria-hidden="true"></i></h2>
        <p>{{ $tournaments }} tournaments</p>
      </a>
    </div>
    <div class="col-sm-2 col-xs-6 text-center">
      <a class="thumbnail">
        <h2><i class="fa fa-futbol-o" aria-hidden="true"></i></h2>
        <p>{{ $games }} games</p>
      </a>
    </div>
    <div class="col-sm-2 col-xs-6 text-center">
      <a class="thumbnail">
        <h2><i class="fa fa-users" aria-hidden="true"></i></h2>
        <p>{{ $users }} users</p>
      </a>
    </div>
    <div class="col-sm-2 col-xs-6 text-center">
      <a class="thumbnail">
        <h2><i class="fa fa-flag" aria-hidden="true"></i></h2>
        <p>3 languages</p>
      </a>
    </div>
  </div>
</div>
@endsection
