<div {{ $attributes }}>
	<label class="form-check form-switch">
	    <input type="checkbox" name="{{ $name }}" class="form-check-input {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }} {{ $inputClass ?? '' }}" {{ $value ? 'checked' : '' }} value="1">
	    <span class="form-check-label">{{ $label }}</span>
	</label>
	<div class="invalid-feedback {{ $errors->has($name)?'d-block':'' }}" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>