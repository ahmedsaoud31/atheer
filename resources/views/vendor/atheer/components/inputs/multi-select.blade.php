<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<select 
			id="select-states"
			type="{{ $type }}"
			name="{{ $name }}"
			class="form-select {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }}"
			placeholder="{{ $placeholder }}"
			multiple>
		@if($placeholder)
		<option value="">{{ $placeholder }}</option>
		@endif
		@foreach($options as $option)
		<option value="{{ $option->value }}"
				{{ ((old($name) && in_array($option->value, old($name))) || ($model && in_array($option->value, $selectedOptions)))?'selected':'' }}
			>{{ $option->text }}</option>
		@endforeach
	</select>
	<div class="invalid-feedback {{ $errors->has($name)?'d-block':'' }}" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>