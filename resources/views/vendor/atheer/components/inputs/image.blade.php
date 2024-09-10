<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    @if($record)
    <div class="row">
        <div class="col-md-2">
            <div><img src="{{ $record->getSmallImage() }}"></div>
        </div>
    </div>
    <br>
    @endif
    <input  type="file"
            name="{{ $name }}"
            class="form-control {{ $errors->has($name)?'is-invalid':(old($name)?'is-valid':'') }} {{ $inputClass ?? '' }}"
            id="{{ $name }}"
            aria-describedby="{{ $name }}Help"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
    >
    @error($name)
        <small id="{{ $name }}Help" class="form-text text-danger">{{ $message }}</small>
    @enderror
</div>