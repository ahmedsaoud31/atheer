<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<input	id="{{ $id }}"
			type="{{ $type }}"
			name="{{ $name }}"
			class="form-control {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }}"
			placeholder="{{ $placeholder }}"
			value="{{ $value }}"
	>
	<div class="invalid-feedback {{ $errors->has($name)?'d-block':'' }}" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>