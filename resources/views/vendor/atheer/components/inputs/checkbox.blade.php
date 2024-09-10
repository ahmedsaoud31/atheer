<div class="custom-control custom-checkbox">
	<input type="checkbox" name="{{ $name }}" class="custom-control-input {{ $inputClass ?? '' }}" id="{{ $name }}" {{ $checked }}>
	<label class="custom-control-label" for="{{ $name }}">{{ $label }}</label>
	@error($name)
	    <small id="{{ $name }}Help" class="form-text text-danger">{{ $message }}</small>
	@enderror
</div>