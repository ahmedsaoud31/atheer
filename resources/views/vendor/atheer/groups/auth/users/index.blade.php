@extends('atheer::layouts.app')

@section('content')
<div class="page-wrapper">
  <div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            {{ $atheer->title ?? '' }}
          </h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="container-xl">
      <!-- Flash message here -->
      @include("atheer::support.templates.widgets.session-alert")

      <!-- Content here -->
      @include("{$atheer->view}.tables.main")
    </div>
  </div>
@endsection

<!-- Ajax section -->
@push('scripts')
<script>
  // change this to enable or disable ajax
  var ajax = true;
</script>
@endpush

<!-- Create script -->
@include("{$atheer->view}.scripts.create")
@include("{$atheer->view}.modals.create")
<!-- End Create script -->

<!-- Edit script -->
@include("{$atheer->view}.scripts.edit")
@include("{$atheer->view}.modals.edit")
<!-- End Edit script -->

<!-- Delete script -->
@include("{$atheer->view}.scripts.delete")
<!-- End Delete script -->

<!-- User roles attach script -->
@include("{$atheer->view}.scripts.roles")
@include("{$atheer->view}.modals.roles")
<!-- End User roles attach script -->

<!-- End Ajax section -->