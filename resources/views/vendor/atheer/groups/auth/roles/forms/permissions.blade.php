@extends('atheer::layouts.app')

@section('content')
<div class="page-wrapper">
  <div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            {{ __('Attach') }} {{ __('form') }}
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
		<div class="card">
			<form method="post" action="{{ route("{$atheer->route}.update-roles") }}">
				@method('POST')
				<div class="card-body">
					<!-- All form errors here -->
		      		@include("atheer::support.templates.widgets.form-alert")

					@include("{$atheer->view}.forms.permissions-form")
				</div>
				<div class="card-footer">
					<div class="row align-items-center">
						<div class="col"></div>
						<div class="col-auto">
							<button type="submit" class="btn btn-primary">{{ __('Attach') }}</button>
						</div>
					</div>
				</div>
			</form>
		</div>
    </div>
  </div>
@endsection