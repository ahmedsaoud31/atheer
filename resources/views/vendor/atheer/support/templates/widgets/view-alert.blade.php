@foreach(['success', 'danger', 'info'] as $value)
	@if(isset($alert) && isset($alert[$value]))
		@if(is_array($alert[$value]))
			@foreach($alert[$value] as $line)
			<div class="alert alert-{{ $value }}">
				{{ $line }}
			</div>
			@endforeach
		@else
			<div class="alert alert-{{ $value }}">
				{{ $alert[$value] }}
			</div>
		@endif
	@endif
@endforeach