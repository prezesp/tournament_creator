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
        <div class="panel-heading">My profile</div>

        <div class="panel-body">
          <a href="{{ url('user/change') }}">Change password</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <ul class="nav nav-tabs tournament-nav">
        <li role="presentation" {{ !isset($_GET['moderated']) ? 'class=active' : ''}}>
          <a href="?">
            Mine
            @if (count($myTournaments) > 0)
              <span class="badge">{{ count(Auth::user()->tournaments) }}</span>
            @endif
          </a>
        </li>
        <li role="presentation" {{ isset($_GET['moderated']) ? 'class=active' : ''}}>
          <a href="?moderated">
            Moderated 
            @if (count($moderatedTournaments) > 0)
              <span class="badge">{{ count(Auth::user()->tournamentsAsModerator()->get()) }}</span>
            @endif
          </a>
        </li>
      </ul>
      <div class="panel panel-default tournament-content-first">
        @if (isset($_GET['moderated']))
        <div class="panel-body">
          @if ($moderatedTournaments->isEmpty())
            <em> No tournaments </em>
          @else
            @include('layouts.tournaments_list', ['tournaments' => $moderatedTournaments])
          @endif
        </div>
        @else
        <div class="panel-body">
          @if ($myTournaments->isEmpty())
            <em> No tournaments </em>
          @else
            @include('layouts.tournaments_list', ['tournaments' => $myTournaments])
          @endif
        </div>
        @endif
      </div>
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
@endsection
