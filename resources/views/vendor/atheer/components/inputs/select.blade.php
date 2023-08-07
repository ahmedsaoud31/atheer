<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<select 
			name="{{ $name }}"
			class="form-select {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }}"
			>
		@if($placeholder)
		<option value="">{{ $placeholder }}</option>
		@endif
		@foreach($options as $option)
		<option value="{{ $option->value }}"
				{{ ((old($name) && old($name) == $option->value) || ($model && $model->{$name} == $option->value))?'selected':'' }}
			>{{ $option->text }}</option>
		@endforeach
	</select>
	<div class="invalid-feedback" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>