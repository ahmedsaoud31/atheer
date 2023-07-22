@extends('atheer::layouts.general')

@section('content')
<div class="page page-center">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
    </div>
    <form class="card card-md" action="{{ route('atheer.register.store') }}" method="post">
      @csrf
      <div class="card-body">
        <h2 class="card-title text-center mb-4">{{ __('Create new account') }}</h2>
        @if($errors->has('public'))
          <div class="alert alert-danger">{{ $errors->first('public') }}</div>
        @elseif($errors->any())
          <div class="alert alert-danger">{{ __('Check errors below') }}</div>
        @endif
        <div class="mb-3">
          <label class="form-label">{{ __('Name') }}</label>
          <input name="name" type="text" class="form-control" placeholder="{{ __('Enter name') }}" value="{{ old('name') ? old('name') : '' }}">
          @if($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
          @endif
        </div>
        <div class="mb-3">
          <label class="form-label">{{ __('Email address') }}</label>
          <input name="email" type="text" class="form-control" placeholder="{{ __('Enter email') }}" value="{{ old('email') ? old('email') : '' }}">
          @if($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
        </div>
        <div class="mb-3">
          <label class="form-label">{{ __('Password') }}</label>
          <div class="input-group input-group-flat">
            <input name="password" type="password" class="form-control"  placeholder="{{ __('Password') }}"  autocomplete="off">
            <span class="input-group-text">
              <span class="link-secondary" title="{{ __('Show password') }}" data-bs-toggle="tooltip">
                @include('atheer::icons.svg.eye')
              </span>
            </span>
          </div>
          @if($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div>
        <div class="mb-3">
          <label class="form-label">{{ __('Password Confirmation') }}</label>
          <div class="input-group input-group-flat">
            <input name="password_confirmation" type="password" class="form-control"  placeholder="{{ __('Password Confirmation') }}"  autocomplete="off">
            <span class="input-group-text">
              <span class="link-secondary" title="{{ __('Show password') }}" data-bs-toggle="tooltip">
                @include('atheer::icons.svg.eye')
              </span>
            </span>
          </div>
          @if($errors->has('password_confirmation'))
            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
          @endif
        </div>
        <div class="mb-3">
          <label class="form-check">
            <input name="terms" type="checkbox" class="form-check-input" {{ old('terms') ? 'checked' : '' }}/>
            <span class="form-check-label">{{ __('Agree the') }} <a href="." tabindex="-1">{{ __('terms and policy') }}</a>.</span>
          </label>
          @if($errors->has('terms'))
            <span class="text-danger">{{ $errors->first('terms') }}</span>
          @endif
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">{{ __('Create new account') }}</button>
        </div>
      </div>
    </form>
    <div class="text-center text-muted mt-3">
      {{ __('Already have account?') }} <a href="{{ route('atheer.login') }}" tabindex="-1">{{ __('Sign in') }}</a>
    </div>
  </div>
</div>
@endsection