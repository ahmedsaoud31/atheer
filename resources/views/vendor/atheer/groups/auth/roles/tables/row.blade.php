<tr class="table-row" data-id="{{ $record->id }}" id="row{{ $record->id }}">
  <td>
    @if($record->name == 'Super Admin')
    <span class="badge bg-secondary">{{ $record->name }}</span>
    @else
    <span class="badge bg-blue">{{ $record->name }}</span>
    @endif
  </td>
  <td>
    {{ $record->getPermissionNames()->count() }}
  </td>
  <td>
    @if($record->name == 'Super Admin')
    <span class="text-secondary">{{ __('Atheer role') }}</span>
    @endif
  </td>
  <td class="text-end">
    <div class="dropdown">
          <button class="btn btn btn-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="true">
            @include("atheer::tabler.icons.svg.settings")
          </button>
          <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
              <!-- If you don't customise action code you can use default action code by include("atheer::support.templates.forms.actions") -->
              <a class="dropdown-item text-primary attach" href="{{ route("{$atheer->route}.permissions", ['id' => $record->id]) }}">
                @include("atheer::tabler.icons.svg.unlink")
                {{ __('Attach') }} {{ __('Permissions') }}
                <div class="spinner-border spinner-border-sm m-0 ms-auto d-none"></div>
              </a>
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
          </div>
        </div>
  </td>
</tr>