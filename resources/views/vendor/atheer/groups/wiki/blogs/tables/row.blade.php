<tr>
	<td>{{ $record->id ?? '' }}</td>
  <td>{{ Str::limit($record->title, 10, "...") }}</td> <td>{{ Str::limit($record->body, 10, "...") }}</td>
	<td class="text-end">
		<div class="dropdown">
          <button class="btn btn btn-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="true">
            @include("atheer::icons.svg.settings")
          </button>
          <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
            <a class="dropdown-item text-primary" href="{{ route("{$route}.edit", $record->id) }}">
            	@include("atheer::icons.svg.edit")
            	{{ __('Edit') }}
            </a>
            <a class="dropdown-item text-danger" href="{{ route("{$route}.destroy", $record->id) }}">
            	@include("atheer::icons.svg.trash")
            	{{ __('Delete') }}
            </a>
          </div>
        </div>
	</td>
</tr>