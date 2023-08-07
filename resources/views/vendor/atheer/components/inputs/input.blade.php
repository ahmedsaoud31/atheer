<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<input	type="{{ $type }}"
			name="{{ $name }}"
			class="form-control {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }}"
			placeholder="{{ $placeholder }}"
			value="{{ $value }}"
	>
	<div class="invalid-feedback" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>