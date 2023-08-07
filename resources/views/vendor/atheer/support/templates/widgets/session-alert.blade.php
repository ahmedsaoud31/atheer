@foreach(['success', 'danger', 'info'] as $value)
	@if(Session::has("alert-{$value}"))
	<div class="alert alert-{{ $value }}">
		{{ Session::get("alert-{$value}") }}
	</div>
	@endif
@endforeach