<tr class="table-row" data-id="{{ $record->id }}" id="row{{ $record->id }}">
  @php($isAtheerPermission = Atheer::isAtheerPermission($record->name))
  <td>
    @if($isAtheerPermission)
    <span class="badge bg-secondary">{{ $record->name }}</span>
    @else
    <span class="badge bg-blue">{{ $record->name }}</span>
    @endif
  </td>
  <td>
    @if($isAtheerPermission)
    <span class="text-secondary">{{ __('Atheer permission') }}</span>
    @endif
  </td>
  <td class="text-end">
    <div class="dropdown">
          <button class="btn btn btn-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="true">
            @include("atheer::tabler.icons.svg.settings")
          </button>
          <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
              <!-- If you don't customise action code you can use default action code by include("atheer::support.templates.forms.actions") -->
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