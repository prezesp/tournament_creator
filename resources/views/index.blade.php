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
<div class="container" id="learn-more">
  <div class="row vspace"></div>
  <div class="row vspace"></div>

  <div class="row">
    <div class="col-sm-5 col-sm-offset-1 vcenter">
      <h3>{{ trans('main.types_title') }}</h3>
      <p class="text-justify">
        {{ trans('main.types_text1') }}
      </p>
      <p>
        {{ trans('main.types_text2') }}
      </p>
    </div>
    <div class="col-sm-1 vcenter"></div>
    <div class="col-sm-4 vcenter">
      <img src="{{ asset('img/welcome/types.png')}}" class="img-responsive"/>
    </div>
  </div>

  <div class="row vspace"></div>
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
      <hr class="welcome-hr"/>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-4 col-sm-offset-1 vcenter">
      <img src="{{ asset('img/welcome/comments.png') }}" class="img-responsive"/>
    </div>
    <div class="col-sm-1 vcenter"></div>
    <div class="col-sm-5 vcenter">
      <h3>{{ trans('main.comments_title') }}</h3>
      <p>
        {{ trans('main.comments_text1') }}
      </p>
      <p>
        {{ trans('main.comments_text2') }}
      </p>
    </div>
  </div>

  <div class="row vspace"></div>
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
      <hr class="welcome-hr"/>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-5 col-sm-offset-1 vcenter">
      <h3>{{ trans('main.export_title') }}</h3>
      <p class="text-justify">
        {{ trans('main.export_text1') }}
      </p>
      <p>

      </p>
    </div>
    <div class="col-sm-1 vcenter"></div>
    <div class="col-sm-4 vcenter">
      <br/>
      <img src="{{ asset('img/welcome/export.png') }}" class="img-responsive img-center"/>
    </div>
  </div>

  <div class="row vspace"></div>
  <div class="row vspace"></div>
</div>
<section class="bg-court-numbers">
  <div class="container">
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <div class="row vspace"></div>
        <div class="row">
          <div class="col-sm-12 text-center">
            <h3>{{ trans('main.tc_in_numbers') }}</h3>
          </div>
        </div>
        <div class="row vspace"></div>
        <div class="row">
          <div class="col-sm-12 text-center">
            <div class="jumbotron">
              <div class="row">
                <div class="col-sm-3 col-xs-6 text-center">
                  <div class="number">
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                    <h4>{{ $tournaments }}</h4>
                    <p>{{ trans('main.tournaments_text', ['p' => $tournaments]) }}</p>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <div class="number">
                    <i class="fa fa-futbol-o" aria-hidden="true"></i>
                    <h4>{{ $games }}</h4>
                    <p>{!! trans('main.games_text', ['p' => $teams]) !!}</p>
                  </div>
                </div>
                <div class="clearfix visible-xs"></div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <div class="number">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <h4>{{ $users }}</h4>
                    <p>{{ trans('main.users_text', ['p' => $users]) }}</p>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <div class="number">
                    <i class="fa fa-flag" aria-hidden="true"></i>
                    <h4>3</h4>
                    <p>{{ trans('main.languages_text') }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row vspace"></div>
      </div>
    </div>
  </div>
</section>
<section class="trusted">
  <div class="container">
    <div class="row">
      <div class="col-sm-2 col-sm-offset-1 vcenter">
        <h3>TRUSTED BY</h3>
      </div>
      <div class="col-sm-4 col-sm-offset-1 vcenter text-center">
        <a href="http://www.basketballclassic.pl">
          <img src="http://basketballclassic.pl/img/layout/logo2.png" style="max-width:150px;"/>
        </a>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function (){
  $('.jumbotron a[class="btn btn-primary"]').click(function() {
    var ua = navigator.userAgent.toLowerCase();
    var isAndroid = ua.indexOf("android") > -1;
    if(isAndroid) {
      $('html, body').animate({
          scrollTop: $('#learn-more').offset().top - 20
      }, 850);
    } else {
      $('html, body').animate({
          scrollTop: $('#learn-more').offset().top + document.body.scrollTop - 20
      }, 850);
    }
  });
});
</script>
@endsection
