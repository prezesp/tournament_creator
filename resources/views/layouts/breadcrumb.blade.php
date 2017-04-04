<div class="welcome-small">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-right">
        <div class="text">
          {{ strToLower($title) }}
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <ol class="breadcrumb">
          <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i></a></li>
          {{ $slot }}
        </ol>
      </div>
    </div>
  </div>
</div>
