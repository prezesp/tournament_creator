@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row vspace"></div>
    <div class="row vspace hidden-sm hidden-xs"></div>
    <div class="row vspace hidden-sm hidden-xs"></div>
    <div class="row vspace hidden-sm hidden-xs"></div>
    <div class="row">
        <div class="col-md-4 col-md-offset-2 vcenter">
            <div class="panel panel-default panel-tc">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group register-form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                              </div>
                              @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('name') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>

                        <div class="form-group register-form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope" style="margin:0 -2px;"></i></span>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                              </div>
                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>

                        <div class="form-group register-form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                              </div>
                              @if ($errors->has('password'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                              </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 vcenter">
          <div class="panel panel-default">
            <div class="panel-body">
              <blockquote class="blockquote blockquote-reverse">
                <p class="mb-0">Human life is like a huge sporting event of which we are both participants and spectators.</p>
                <footer class="blockquote-footer"> Antoni Gołubiew <cite title="Source Title">Letters to a Friend</cite></footer>
              </blockquote>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
  @if (App::getLocale() == 'es')
    <link href="{{ asset('css/register-styles.css') }}" rel="stylesheet">
  @endif
@endsection
