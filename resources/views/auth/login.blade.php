@extends('layouts.masterlogin')

@section('title-head', 'Login')

@section('content')
<div class="content-body">
  <div class="auth-wrapper auth-v1 px-1">
    <div class="auth-inner py-2">
      <div class="card mb-0">
        <div class="card-body">
          <a href="#" class="brand-logo mb-25">
            <img src="{{asset('images/slua.png')}}" height="50" alt="">
          </a>
          <h4 class="card-title font-weight-bold text-center mt-1 mb-50">Learning Management System</h4>
          <p class="card-text text-center mb-1">SMA (SLUA) Saraswati 1 Denpasar</p>
          <form class="auth-login-form mt-2" action="{{route('login')}}" method="POST">
            {!! csrf_field() !!}
            <div class="form-group">
              <label class="form-label " for="username">Username</label>
              <input class="form-control mb-25" id="usernamel" type="text" name="username" aria-describedby="username" autofocus="" tabindex="1" required>
              @if ($errors->has('username'))
                <span class="text-danger my-50">
                  <center>{{ $errors->first('username') }}</center>
                </span>
              @endif
            </div>
            <div class="form-group">
              <div class="d-flex justify-content-between">
                <label class="" for="password">Password</label>
                @if (Route::has('password.request'))
                <a href="{{route('reset')}}"><small>Lupa Password?</small></a>
                @endif
              </div>
              <div class="input-group input-group-merge form-password-toggle">
                <input class="form-control form-control-merge" id="password" type="password" name="password" placeholder="············" aria-describedby="password" tabindex="2" required>
                <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
              </div>
              @if ($errors->has('password'))
                <span class="text-danger my-50">
                  <center>{{ $errors->first('password') }}</center>
                </span>
              @endif
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="remember-me" type="checkbox" tabindex="3" />
                <label class="custom-control-label" for="remember-me"> Ingat Saya</label>
              </div>
            </div>
            <button class="btn btn-success btn-block" tabindex="4">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
