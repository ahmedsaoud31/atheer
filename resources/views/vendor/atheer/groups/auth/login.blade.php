@extends('atheer::layouts.general')

@section('content')
<div class="page page-center">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
    </div>
    <form class="card card-md" action="{{ route('atheer.login.store') }}" method="post" autocomplete="off">
      @csrf
      <div class="card-body">
        <h2 class="card-title text-center mb-4">{{ __('Login to your account') }}</h2>
        @if($errors->has('public'))
          <div class="alert alert-danger">{{ $errors->first('public') }}</div>
        @elseif($errors->any())
          <div class="alert alert-danger">{{ __('Check errors below') }}</div>
        @endif
        <div class="mb-3">
          <label class="form-label">{{ __('Email address') }}</label>
          <input name="email" type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter email') }}" autocomplete="off" value="{{ old('email') ? old('email') : 'admin@admin.com' }}">
          @if($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
        </div>
        <div class="mb-2">
          <label class="form-label">
            {{ __('Password') }}
            <span class="form-label-description">
              <a href=".">{{ __('I forgot password') }}</a>
            </span>
          </label>
          <div class="input-group input-group-flat">
            <input name="password" type="password" class="form-control"  placeholder="{{ __('Password') }}"  autocomplete="off" value="123456789">
            <span class="input-group-text">
              <a href="#" class="link-secondary" title="{{ __('Show password') }}" data-bs-toggle="tooltip">
                @include('atheer::icons.svg.eye')
              </a>
            </span>
          </div>
          @if($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div>
        <div class="mb-2">
          <label class="form-check">
            <input name="remember" type="checkbox" class="form-check-input" {{ old('remember') ? 'checked' : '' }}/>
            <span class="form-check-label">{{ __('Remember me on this device') }}</span>
          </label>
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">{{ __('Sign in') }}</button>
        </div>
      </div>
      <!--
      <div class="hr-text">{{ __('or') }}</div>
      <div class="card-body">
        <div class="mb-3">
          <a href="#" class="btn text-white bg-red w-100">
              @include('atheer::icons.svg.brand-google')
              {{ __('Login with Google') }}
            </a>
        </div>
        <div class="mb-3">
          <a href="#" class="btn text-white bg-blue w-100">
              @include('atheer::icons.svg.brand-facebook')
              {{ __('Login with Facebook') }}
            </a>
        </div>
        <div class="mb-3">
          <a href="#" class="btn text-white bg-azure w-100">
              @include('atheer::icons.svg.brand-twitter')
              {{ __('Login with Twitter') }}
            </a>
        </div>
      </div>
      -->
    </form>
    <div class="text-center text-muted mt-3">
      {{ __('Don\'t have account yet?') }} <a href="{{ route('atheer.register') }}" tabindex="-1">{{ __('Sign up') }}</a>
    </div>
  </div>
</div>
@endsection