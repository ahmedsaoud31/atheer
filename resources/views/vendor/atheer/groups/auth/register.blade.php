@extends('atheer::layouts.general')

@section('content')
<div class="page page-center">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ Atheer::publicUrl() }}/static/logo-orange.svg" height="150" alt=""></a>
    </div>
    <form class="card card-md" action="{{ route('atheer.register.store') }}" method="post">
      @csrf
      <div class="card-body">
        <h2 class="card-title text-center mb-4">{{ __('Create new account') }}</h2>
        <!-- All form errors here -->
        @include("atheer::support.templates.widgets.form-alert")
        <x-atheer-components::inputs.input class="mb-3" name="name" :label="__('Name')" :placeholder="__('Enter').' '.__('name').' ...'" />
        <x-atheer-components::inputs.input class="mb-3" name="email" :label="__('Email address')" :placeholder="__('Enter').' '.__('email').' ...'" />
        <x-atheer-components::inputs.password class="mb-3" name="password" :label="__('Password')" :placeholder="__('Enter').' '.__('password').' ...'" />
        <x-atheer-components::inputs.password class="mb-3" name="password_confirmation" :label="__('Password confirmation')" :placeholder="__('Enter').' '.__('password confirmation').' ...'" />
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
  @include("atheer::layouts.general-languages")
</div>
@endsection