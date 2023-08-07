<div {{ $attributes }}>
	<label class="form-check form-switch">
	    <input type="checkbox" name="{{ $name }}" class="form-check-input {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }}" {{ $value ? 'checked' : '' }} value="1">
	    <span class="form-check-label">{{ $label }}</span>
	</label>
	<div class="invalid-feedback" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>