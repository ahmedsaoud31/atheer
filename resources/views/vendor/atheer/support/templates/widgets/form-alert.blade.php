@if ($errors->any())
	<div class="alert alert-danger">
		{{ __('Please fix form validation') }}
		@if($errors->has('public'))
		<ul><li>{{ $errors->first('public') }}</li></ul>
		@endif
	</div>
@endif