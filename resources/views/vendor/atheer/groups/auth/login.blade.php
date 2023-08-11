@extends('atheer::layouts.general')

@section('content')
<div class="page page-center">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ Atheer::publicUrl() }}/static/logo-orange.svg" height="150" alt=""></a>
    </div>
    <!-- Flash message here -->
    @include("atheer::support.templates.widgets.session-alert")
    <form class="card card-md" action="{{ route('atheer.login.store') }}" method="post" autocomplete="off">
      @csrf
      <div class="card-body">
        <h2 class="card-title text-center mb-4">{{ __('Login to your account') }}</h2>
        <!-- All form errors here -->
        @include("atheer::support.templates.widgets.form-alert")

        <x-atheer-components::inputs.input class="mb-3" name="email" :label="__('Email')" :placeholder="__('Enter').' '.__('email').' ...'" value="admin@admin.com" />
        <x-atheer-components::inputs.password class="mb-3" name="password" :label="__('Password')" :placeholder="__('Enter').' '.__('password').' ...'" value="123456789" />
        <div class="mb-3">
          <label class="form-label">
            <span class="form-label-description">
              <a href="{{ route('atheer.forgot-password.index') }}">{{ __('I forgot password') }}</a>
            </span>
          </label>
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
    </form>
    <div class="text-center text-muted mt-3">
      {{ __('Don\'t have account yet?') }} <a href="{{ route('atheer.register') }}" tabindex="-1">{{ __('Sign up') }}</a>
    </div>
  </div>
  @include("atheer::layouts.general-languages")
</div>
@endsection