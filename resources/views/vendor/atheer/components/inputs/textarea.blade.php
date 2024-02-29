<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<textarea 
			id="{{ $id }}"
			name="{{ $name }}"
			class="form-control{{ $errors->has($name)?' is-invalid':(old($name)?' is-valid':'') }}"
			placeholder="{{ $placeholder }}"
			{{ $attributes['rows'] ?? '3' }}
			rows="10"
	>{{ $value }}</textarea>
	<div class="invalid-feedback {{ $errors->has($name)?'d-block':'' }}" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>