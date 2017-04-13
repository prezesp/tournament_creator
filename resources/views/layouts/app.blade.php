<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
    
    @yield('styles')

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app" style="min-height: 100vh;">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                @include('layouts.mobile_menu')

                <div class="collapse navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('tournament.index') }}">{{ trans('menu.browse') }}</a></li>
                        @if (!Auth::guest())
                            <li><a href="{{ route('tournament.create') }}">{{ trans('menu.create') }}</a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav">
                      <li class="text-left">
                        {{ Form::open(array('route' => 'tournament.search', 'class' => 'search-form', 'method' => 'GET')) }}
                          <div class="form-group has-feedback">
                            <i class="fa fa-search form-control-feedback"></i>
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" class="form-control" name="q" placeholder="{{ trans('menu.search') }}" autocomplete="off" maxlength="32" value="{{ isset($_GET['q']) ? $_GET['q'] : ''}}">
                          </div>
                        {{ Form::close() }}
                      </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">

                        @include('layouts/lang_chooser')
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">{{ trans('menu.login') }}</a></li>
                            <li><a href="{{ route('register') }}">{{ trans('menu.register') }}</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                  <li>
                                    <a href="{{ url('/home') }}">Dashboard</a>
                                  </li>
                                  <li>
                                      <a href="{{ route('logout') }}"
                                          onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                          {{ trans('menu.logout') }}
                                      </a>

                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                      </form>
                                  </li>
                                </ul>
                            </li>
                        @endif
                    </ul>

                </div>
            </div>
        </nav>

        @yield('content')
    </div>


    <footer class="navbar navbar-default navbar-static-bottom">
      <div class="container">
        <div class="row">

          <div class="col-sm-4">
            <!--p class="navbar-text pull-right"><a href="#">Changelog</a></p-->
          </div>
          <div class="col-sm-4 col-sm-offset-2">
            <p class="navbar-text pull-right">built by <strong>pw</strong> &copy; 2017</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/validator.min.js') }}"></script>
    <script src="{{ asset('js/tc_plugins.js') }}"></script>
    <script src="{{ asset('js/bootstrap3-typeahead.min.js') }}"></script>
</body>
</html>
