@extends('atheer::layouts.general')

@section('content')
<div class="page page-center">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ Atheer::publicUrl() }}/static/logo-orange.svg" height="150" alt=""></a>
    </div>
    <!-- Flash message here -->
    @include("atheer::support.templates.widgets.session-alert")
    <form class="card card-md" action="{{ route('atheer.forgot-password.store') }}" method="post" autocomplete="off">
      @csrf
      <div class="card-body">
        <h2 class="card-title text-center mb-4">{{ __('Send reset link form') }}</h2>
        <!-- All form errors here -->
        @include("atheer::support.templates.widgets.form-alert")

        <x-atheer-components::inputs.input class="mb-3" name="email" :label="__('Email')" :placeholder="__('Enter').' '.__('email').' ...'" />
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">{{ __('Send reset link') }}</button>
        </div>
      </div>
    </form>
  </div>
  @include("atheer::layouts.general-languages")
</div>
@endsection