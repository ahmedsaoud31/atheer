<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<textarea 
			name="{{ $name }}"
			class="form-control{{ $errors->has($name)?' is-invalid':(old($name)?' is-valid':'') }}"
			placeholder="{{ $placeholder }}"
			{{ $attributes['rows'] ?? '3' }}
			rows="10"
	>{{ $value }}</textarea>
	<div class="invalid-feedback" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>