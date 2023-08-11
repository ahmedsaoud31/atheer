@extends('atheer::layouts.app')

@section('content')
<div class="page-wrapper">
  <div class="container-xl">
    <!-- Page title -->
    
  </div>
  <div class="page-body">
    <div class="container-xl">
      <!-- Flash message here -->
      @include("atheer::support.templates.widgets.session-alert")
    </div>
  </div>
@endsection

@push('libs')

@endpush

@push('models')
  
@endpush