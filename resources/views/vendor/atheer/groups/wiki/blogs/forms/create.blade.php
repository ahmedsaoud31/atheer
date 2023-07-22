@extends('atheer::layouts.app')

@section('content')
<div class="page-wrapper">
  <div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            {{ __('Create') }} {{ __($name) }} {{ __('form') }}
          </h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="container-xl">
      <!-- Content here -->
		<div class="card">
			<form method="post" action="{{ route("{$route}.store") }}">
				@csrf
				<div class="card-body">
					@include("atheer::groups.{$group}.{$item}.forms.form")
				</div>
				<div class="card-footer">
					<div class="row align-items-center">
						<div class="col"></div>
						<div class="col-auto">
							<button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
						</div>
					</div>
				</div>
			</form>
		</div>
    </div>
  </div>
@endsection