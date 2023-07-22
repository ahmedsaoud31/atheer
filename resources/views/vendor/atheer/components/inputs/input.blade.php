<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<input	type="{{ $type }}"
			name="{{ $name }}"
			class="form-control {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }}"
			placeholder="{{ $placeholder }}"
			value="{{ $value }}"
	>
	@error($name)
	    <div class="invalid-feedback">{{ $message }}</div>
	@enderror
</div>