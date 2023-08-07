<div {{ $attributes }}>
	<label class="form-label">{{ $label }}</label>
	<div class="input-group input-group-flat">
		<input	type="password"
				name="{{ $name }}"
				class="form-control {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }}"
				placeholder="{{ $placeholder }}"
				value="{{ $value }}"
		>
	    <span class="input-group-text text-danger" onclick="Atheer.togglePassword(this)">
	      <a href="#" class="link-secondary" title="{{ __('Show password') }}" data-bs-toggle="tooltip">
	        @include('atheer::tabler.icons.svg.eye-off')
	      </a>
	      <a href="#" class="link-secondary d-none" title="{{ __('Hide password') }}" data-bs-toggle="tooltip">
	        @include('atheer::tabler.icons.svg.eye')
	      </a>
	    </span>
	</div>
	<div class="invalid-feedback" data-name="{{ $name }}">{{ $errors->has($name) ? $errors->first($name) : '' }}</div>
</div>