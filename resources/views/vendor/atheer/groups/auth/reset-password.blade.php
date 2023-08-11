@extends('atheer::layouts.general')

@section('content')
<div class="page page-center">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ Atheer::publicUrl() }}/static/logo-orange.svg" height="150" alt=""></a>
    </div>
    <!-- Flash message here -->
    @include("atheer::support.templates.widgets.session-alert")

    <!-- Flash message here -->
    @include("atheer::support.templates.widgets.view-alert")
    
    <form class="card card-md" action="{{ request()->fullUrl() }}" method="post" autocomplete="off">
      @csrf
      @method('PUT')
      <div class="card-body">
        <h2 class="card-title text-center mb-4">{{ __('Reset your password form') }}</h2>
        <!-- All form errors here -->
        @include("atheer::support.templates.widgets.form-alert")
        
        <x-atheer-components::inputs.hidden name="expires" :value="request()->expires" />
        <x-atheer-components::inputs.hidden name="user" :value="request()->user" />
        <x-atheer-components::inputs.hidden name="signature" :value="request()->signature" />
        <x-atheer-components::inputs.password class="mb-3" name="password" :label="__('New password')" :placeholder="__('Enter').' '.__('password').' ...'" />
        <x-atheer-components::inputs.password class="mb-3" name="password_confirmation" :label="__('Password confirmation')" :placeholder="__('Enter').' '.__('password confirmation').' ...'" />
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">{{ __('Save new password') }}</button>
        </div>
      </div>
    </form>
  </div>
  @include("atheer::layouts.general-languages")
</div>
@endsection