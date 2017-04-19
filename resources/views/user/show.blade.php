@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row vspace"></div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2><i class="fa fa-user"></i> {{ $user->name }}</h2>
          <p>Registered at {{ $user->created_at }}</p>
        </div>
      </div>
      
      <div class="panel panel-default">
        <div class="panel-heading">Tournaments</div>

        <div class="panel-body">
          @if ($tournaments->isEmpty())
            <em> No tournaments </em>
          @else
            @include('layouts.tournaments_list', ['tournaments' => $tournaments])
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
