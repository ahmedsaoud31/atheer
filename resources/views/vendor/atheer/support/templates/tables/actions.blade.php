<a class="dropdown-item text-primary edit" href="{{ route("{$atheer->route}.edit", $record->id) }}">
  @include("atheer::tabler.icons.svg.edit")
  {{ __('Edit') }}
  <div class="spinner-border spinner-border-sm m-0 ms-auto d-none"></div>
</a>
<form class="p-0 m-0" method="post" action="{{ route("{$atheer->route}.destroy", $record->id) }}">
  @csrf
  @method('DELETE')
  <button class="dropdown-item text-danger delete" type="submit">
    @include("atheer::tabler.icons.svg.trash")
    {{ __('Delete') }}
    <div class="spinner-border spinner-border-sm m-0 ms-auto d-none"></div>
  </button>
</form>