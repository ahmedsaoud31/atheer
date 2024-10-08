@foreach($options as $option)
<div {{ $attributes }}>
	<label class="form-check form-switch">
	    <input type="checkbox" name="{{ $name }}[]" class="form-check-input {{ $inputClass ?? '' }}" {{ in_array($option->value, $selections)?'checked' : '' }} value="{{ $option->value }}">
	    <span class="form-check-label">{{ $option->text }}</span>
	</label>
</div>
@endforeach
<div class="invalid-feedback {{ $errors->has($name)?'d-block':'' }}" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>