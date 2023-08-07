@foreach($options as $option)
<div {{ $attributes }}>
	<label class="form-check form-switch">
	    <input type="checkbox" name="{{ $name }}[]" class="form-check-input" {{ in_array($option->value, $selections)?'checked' : '' }} value="{{ $option->value }}">
	    <span class="form-check-label">{{ $option->text }}</span>
	</label>
</div>
@endforeach
<div class="invalid-feedback" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>