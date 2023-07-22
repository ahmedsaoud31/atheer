<div class="form-group">
	<label for="{{ $name }}">{{ $label }}</label>
	<select name="{{ $name }}"
			class="form-control {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }} {{ $class }}"
			multiple="multiple"
			id="{{ $name }}"
			aria-describedby="{{ $name }}Help"
			>
		@if($placeholder)
		<option value="">{{ $placeholder }}</option>
		@endif
		@foreach($options as $option)
		<option value="{{ $option->value }}"
				@if(in_array($option->value, $values))
				selected
				@endif
				{{ ((old($name) && old($name) == $option->value) || ($record && $record->{$name} == $option->value))?'selected':'' }}
			>{{ $option->text }}</option>
		@endforeach
	</select>
	@error($name)
	    <small id="{{ $name }}Help" class="form-text text-danger">{{ $message }}</small>
	@enderror
</div>