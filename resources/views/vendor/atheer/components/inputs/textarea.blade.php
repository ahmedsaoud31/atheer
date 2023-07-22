<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<textarea 
			name="{{ $name }}"
			class="form-control{{ $errors->has($name)?' is-invalid':(old($name)?' is-valid':'') }}"
			placeholder="{{ $placeholder }}"
			{{ $attributes['rows'] ?? '3' }}
	>{{ $value }}</textarea>
	@error($name)
	    <div class="invalid-feedback">{{ $message }}</div>
	@enderror
</div>