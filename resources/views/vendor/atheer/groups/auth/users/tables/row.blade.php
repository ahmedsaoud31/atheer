<tr class="table-row" data-id="{{ $record->id }}" id="row{{ $record->id }}">
  <td>{{ $record->id ?? '' }}</td>
  <td>{{ Str::limit($record->name, 30, "...") }}</td>
	<td>{{ Str::limit($record->email, 30, "...") }}</td>
	<td>
    @foreach($record->getRoleNames() as $role)
    <span class="badge badge-sm bg-blue">{{ $role }}</span>
    @endforeach
  </td>
  <td class="text-end">
    <div class="dropdown">
          <button class="btn btn btn-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="true">
            @include("atheer::tabler.icons.svg.settings")
          </button>
          <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
              <!-- If you don't customise action code you can use default action code by include("atheer::support.templates.forms.actions") -->
              <a class="dropdown-item text-primary attach" href="{{ route("{$atheer->route}.roles", ['id' => $record->id]) }}">
                @include("atheer::tabler.icons.svg.unlink")
                {{ __('Attach') }} {{ __('Roles') }}
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