<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
	@foreach($radios as $radio)
	<div class="custom-control custom-radio">
        <input 	type="radio"
        		id="radio-{{ $radio->value }}"
        		name="{{ $name }}"
        		class="custom-control-input {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }} {{ $inputClass ?? '' }}"
				value="{{ $radio->value }}"
				{{ $radio->checked }}
        		>
        <label class="custom-control-label" for="radio-{{ $radio->value }}">{{ ucfirst($radio->label) }}</label>
    </div>
	@endforeach
	@error($name)
	    <small id="{{ $name }}Help" class="form-text text-danger">{{ $message }}</small>
	@enderror
</div>