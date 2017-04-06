<?php
$current_lang = App::getLocale() == null ? 'en' : App::getLocale();

$languages = array('en', 'es', 'pl');
$languages = array_diff($languages, array($current_lang));

?>
<div class="hidden-sm hidden-md hidden-lg nav-mobile">
  <div class="collapse navbar-collapse" id="app-navbar-collapse">
    <ul class="nav navbar-nav">
      <li>
        <div class="container">
          <div class="row">

            {{-- Search form --}}
            <div class="col-xs-2 navbar-mobile-button search-button">
              <a class="thumbnail text-center">
                {{ Form::open(array('route' => 'tournament.search', 'class' => 'search-form', 'method' => 'GET')) }}
                  <div class="form-group has-feedback">
                    <i class="fa fa-search form-control-feedback"></i>
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" class="form-control" name="q" placeholder="{{ trans('menu.search') }}" autocomplete="off" maxlength="32" value="{{ isset($_GET['q']) ? $_GET['q'] : ''}}">
                  </div>
                {{ Form::close() }}
              </a>
            </div>

            {{-- Other buttons --}}
            <div class="col-xs-2 navbar-mobile-button">
              <a href="{{ route('tournament.index') }}" class="thumbnail text-center" title="{{ trans('menu.browse') }}">
                <i class="fa fa-folder-open" aria-hidden="true"></i>
              </a>
            </div>
            @if (!Auth::guest())
              <div class="col-xs-2 navbar-mobile-button">
                <a href="{{ route('tournament.create') }}" class="thumbnail text-center" title="{{ trans('menu.create') }}">
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
              </div>
            @endif
            @if (!Auth::guest())
              <div class="col-xs-2 navbar-mobile-button">
                <a href="{{ url('/home') }}" class="thumbnail text-center" title="Dashboard">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </a>
              </div>
              <div class="col-xs-2 navbar-mobile-button">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="thumbnail text-center" title="{{ trans('menu.logout') }}">
                  <i class="fa fa-power-off" aria-hidden="true"></i>
                </a>
              </div>
            @else
              <div class="col-xs-2 navbar-mobile-button">
              </div>
              <div class="col-xs-2 navbar-mobile-button">
                <a href="{{ route('login') }}" class="thumbnail text-center" title="{{ trans('menu.login') }}">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </a>
              </div>
            @endif
            <div class="col-xs-2 navbar-mobile-button {{ Auth::guest() ? 'pull-right' : '' }}">
              <a href="#"
                 class="dropdown-toggle thumbnail text-center"
                 role="button"
                 aria-expanded="false"
                 data-toggle="collapse"
                 data-target="#app-navbar-languages">
                  {{ strtoupper($current_lang) }}<span class="caret"></span>
              </a>
            </div>
          </div>
        </div>
      </li>
    </ul>

    {{-- List with app languages --}}
    <ul class="collapse navbar-collapse nav navbar-nav" id="app-navbar-languages">
      @foreach($languages as $lang)
        <li>
          <a href="{{ url('locale/'.$lang) }}">
            {{ Html::image('img/flags/'.$lang.'.png') }} {{ strtoupper($lang) }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>

</div>

<script>
$( document ).ready(function() {
  $('.search-button a').hover(function() {
    $(this).parent().animate( { width: "100%"}, {
      queue: false,
      duration: 350
    });
    $('i', this).css('position', 'absolute');
    $('i', this).animate( {  margin: '0'}, {
      queue: false,
      duration: 350
    });
    $('input', this).animate( { opacity: 1}, {
      queue: false,
      duration: 350
    });
    $(this).closest('.row').children(':not(.search-button)').animate(
      {
        width: "0%",
        opacity: 0
      },
      {
        queue: false,
        duration: 200,
        complete: function() {
          $(this).css('display', 'none');
        }
      }
    );
  },
  function() {
    $('input', this).animate( { opacity: 0}, {
      queue: false,
      duration: 350
    });
    $(this).parent().animate( { width: "16.66667%"}, {
      queue: false,
      duration: 200,
      complete : function() {
        $('i', this).css('position', 'relative').css('margin', 'auto');
        $(this).closest('.row').children(':not(.search-button)').css('display', 'block');
        $(this).closest('.row').children(':not(.search-button)').animate(
          {
            width: "16.66667%",
            opacity: 1
          },
          {
            queue: false,
            duration: 350
          }
        );
      }
    });

  });
});
</script>
